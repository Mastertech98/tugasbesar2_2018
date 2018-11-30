var mysql = require('mysql');

var db = mysql.createConnection({
    host: "localhost",
    user: "root",
    port: "3307",
    password: "",
    database: "bank_webservice"
});

module.exports = db;