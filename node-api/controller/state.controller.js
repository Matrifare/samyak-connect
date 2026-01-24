const { db } = require('../database.js');
const { findByQuery } = require("../controller/common.controller.js");

const State = db.states;

//retrieve approved states
module.exports.findAllApproved = (req, res) => {
    console.log("all approved"); 
    State.findAll({ where: { status: 'APPROVED' } })
      .then(data => {
        res.send(data);
      })
      .catch(err => {
        console.error("Error while fetching all approved states:", err);
        res.status(500).send({
          message:
            err.message || "Error occurred while retrieving approved states."
        });

      });

}

//retrieve state by country code
module.exports.findAllByCountry = (req, res) => {
    console.log("all by country code");
    const countrycode = req.query.countrycode;
    State.findAll({ where: { country_code: countrycode, status: 'APPROVED' } })
    .then(data => {
        res.send(data);
    }).catch(err => {
      console.error("Error while fetching states for country:", err);
       res.status(500).send({
           message:
              err.message || "Error while fetching states for country."
       }); 
    });
}

//retrieve state by query
module.exports.findByQuery = (req, res) => {
    return findByQuery(State, req, res);
}