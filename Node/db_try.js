var db_query1 = require("./db_query.js");
//var db_query2 = require("./db_query.js");
db_query1("INSERT INTO `nasabah` (`Nama`, `No_Kartu`, `Saldo`) VALUES ('Dicky Adrian', '102938475647', '15000000'); SELECT * FROM `nasabah`;",function(data){
    console.log('Nasabah berhasil di update');
});

// db_query1("SELECT * FROM nasabah;",function(data){
//      console.log(data);
// });