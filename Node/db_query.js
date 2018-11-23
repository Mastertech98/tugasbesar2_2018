var db = require("./db_config.js");

var queryResult = function getQueryResult(sql,callback){
    db.connect();
    db.query(sql,function (err, result) {
        if (err) throw err;
        // result.forEach(hasil => {
        //     //console.log(hasil);
        //     //data_Result.push(hasil);
        //     //console.log(data_Result);
        // });
        callback(result);
    });
    db.end();
};

module.exports = queryResult;  