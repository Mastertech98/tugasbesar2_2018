var db_query = require("./db_query.js");
db_query("SELECT * FROM nasabah",function(data){
    console.log(data);
});