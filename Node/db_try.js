var db_query = require("./db_config.js");
db_query("SELECT * FROM nasabah ",
     function(data){
     console.log(data);
});
// db_query("INSERT INTO `nasabah` (`Nama`, `No_Kartu`, `Saldo`) VALUES ('Dicky Adrian', '102938475647', '15000000');",function(data){
//     console.log('Nasabah berhasil di update');
// });
db_query("SELECT * FROM transaksi ",
     function(data){
     console.log(data);
});
// db_query("SELECT count(Nama) AS count_card FROM nasabah WHERE No_Kartu = 121234345656 GROUP BY No_Kartu",
//      function(data){
//      console.log(data);
// });  
// db_query("SELECT * FROM transaksi ",
//      function(data){
//      console.log(data);
// });