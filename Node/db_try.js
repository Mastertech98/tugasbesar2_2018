var db_query = require("./db_query.js");
db_query("SELECT * FROM nasabah WHERE Nama = 'William Juniarta Hadiman'",function(data){
    console.log(data);
});