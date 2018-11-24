const express = require('express');
const router = express.Router();

var db_query = require("./db_query.js");

router.get('/check/:cardNumber', (req, res, next) => {
    var cardNumber = req.params.cardNumber;
    var query = 'SELECT Nama FROM nasabah WHERE No_Kartu = ' + cardNumber + ' GROUP BY No_Kartu';
    
    db_query(query, function(data) {
        var isCardExist = false;
        if (data.length > 0) {
            isCardExist = true;
            console.log('changed isCardExist = true');
        }

        res.status(200).json({
            "cardExist" : isCardExist
        });
    });
});

module.exports = router;