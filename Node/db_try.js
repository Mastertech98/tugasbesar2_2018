/**
 * A guide on how to call the database
 */

var db = require("./db_config.js");

db.connect(function(err) {
     var card_number = 1000;
     db.query('SELECT * FROM nasabah WHERE No_Kartu=?', [card_number], function(err, result) {
          console.log(result);
     });
});