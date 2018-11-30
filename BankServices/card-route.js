const express = require('express');
const router = express.Router();

var db = require("./db_config.js");

/**
 * GET method
 * /card/check?cardNumber={card number}
 */
router.get('/check', (req, res, next) => {
    var card_number = req.query.cardNumber;
    var query = 'SELECT Nama FROM nasabah WHERE No_Kartu = ' + card_number + ' GROUP BY No_Kartu';
    
    db.connect(function(err) {
        db.query('SELECT Nama FROM nasabah WHERE No_Kartu = ?', [card_number], function(err, result) {
            var isCardExist = false;
            if (result.length > 0) {
                isCardExist = true;
            }
        
            res.status(200).json({
                "exist" : isCardExist
            });
        });
    });

    console.log('GET request: /card/check?cardNumber=' + card_number);
});

module.exports = router;