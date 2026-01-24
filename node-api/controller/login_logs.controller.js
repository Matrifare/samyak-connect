const { db } = require("../database.js");
const { findByQuery } = require("./common.controller");

const Loginlog = db.loginlogs;

module.exports.create = (req, res) => {
    console.log("creating login log");
    // Validate request
      if (!req.body.matri_id) {
        res.status(400).send({
          message: "login id can not be empty!"
        });
        return;
      }
  
      if (!req.body.client_ip) {
          res.status(400).send({
            message: "client ip can not be empty!"
          });
          return;
      }    

      if (!req.body.user_session){
          res.status(400).send({
              message: "session can not be empty"
          });
          return;  
      } 

        //create login logs
      const login_logs = {
          id: req.body.id,
          matri_id: req.body.matri_id,
          login_time: req.body.login_time,
          server_ip: req.body.server_ip,
          client_ip: req.body.client_ip,
          url: req.body.url,
          browser: req.body.browser,
          user_session: req.body.user_session
      }
  
      //save login logs in database    
      Loginlog.create(login_logs).then(data=> {
          res.send(data)
      }).catch(err => {
      console.error("Error while creating login logs:", err);
             res.status(500).send({
             message: err.message || "Some error occurred while creating login logs"
      });
  
    });
    
}


module.exports.findByQuery = (req, res) => {
  return findByQuery(Loginlog, req, res);
}