var db_query = require("./db_query.js");
// db_query("INSERT INTO `nasabah` (`Nama`, `No_Kartu`, `Saldo`) VALUES ('Dicky Adrian', '102938475647', '15000000');",function(data){
//     console.log('Nasabah berhasil di update');
// });
db_query("SELECT * FROM nasabah",function(data){
     console.log(data);
});