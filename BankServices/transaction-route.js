const express = require('express');
const router = express.Router();

var mysql = require('mysql');

var db = require('./db_config');

/**
 * POST method
 * /transaction?sender={sender card number}&receiver={receiver card number}&amount={transfer amount}
 */
router.post('/', (req, res, next) => {
    var sender_card_number = req.query.sender;
    var receiver_card_number = req.query.receiver;
    var amount = req.query.amount;

    db.connect(function(err) {
        db.query('SELECT Saldo FROM nasabah WHERE No_Kartu = ?', [sender_card_number], function (err, result) {
            if (err) throw err;
            if (result[0]['Saldo'] >= amount) {
                db.query('UPDATE nasabah SET Saldo = Saldo - ? WHERE No_Kartu = ?', [amount, sender_card_number], function(err, result) {
                    if (err) throw err;
                });
                
                db.query('UPDATE nasabah SET Saldo = Saldo + ? WHERE No_Kartu = ?', [amount, receiver_card_number], function(err, result) {
                    if (err) throw err;
                });
                
                db.query('INSERT INTO transaksi (No_Kartu_Pengirim, No_Kartu_Penerima, Jumlah, Waktu_Transaksi) VALUES(?, ?, ?, NOW())', [sender_card_number, receiver_card_number, amount], function(err, result) {
                    if (err) throw err;
                });
                
                res.json({
                    success: true,
                    message: 'Transaction success'
                });
            } else {
                res.json({
                    success: false,
                    message: 'Balance not enough'
                });
            }
        });
    });

    console.log('POST request: /transaction?sender=' + sender_card_number + '&receiver=' + receiver_card_number + '&amount=' + amount);
});

module.exports = router;