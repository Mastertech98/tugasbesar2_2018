var db = require("./db_config.js");

var queryResult = function getQueryResult(sql,callback){
    db.connect();
    db.query(sql,function (err, result) {
        if (err) throw err;
        callback(JSON.stringify(result));
    });
    db.end();
};

module.exports = queryResult;  