var mysql = require('mysql');

var queryResult = function getQueryResult(sql,callback){
    var db = mysql.createConnection({
        host: "localhost",
        user: "root",
        password: "",
        database: "bank_webservice"
    });

    db.connect(function(err){
        db.query(sql,function (err, result) {
            if (err) throw err;
            callback(result);
            db.end(); 
        });
    });
};

module.exports = queryResult;