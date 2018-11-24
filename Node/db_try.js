var db_query = require("./db_query.js");
// db_query("INSERT INTO `nasabah` (`Nama`, `No_Kartu`, `Saldo`) VALUES ('Dicky Adrian', '102938475647', '15000000');",function(data){
//     console.log('Nasabah berhasil di update');
// });
db_query("SELECT count(Nama) AS count_card FROM nasabah WHERE No_Kartu = 121234345656 GROUP BY No_Kartu",
     function(data){
     console.log(data);
});
