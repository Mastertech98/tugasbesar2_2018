var db = require("./db_config.js");

db.connect(function(err) {
    if (err) throw err;
    
    let sql = `SELECT * FROM nasabah`;
    db.query(sql, function (err, result) {
        if (err) throw err;
        result.forEach(hasil => {
            console.log(`${hasil.Nama} \t ${hasil.No_Kartu} \t ${hasil.Saldo}`);
        })
        
    });
});

//db.release();