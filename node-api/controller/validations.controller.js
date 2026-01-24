const { db } = require("../database.js");
const Register = db.registers;

// check email existence
module.exports.checkEmail = (req, res) => {
  console.log("checkEmail", req.query.email);
  Register.findOne({
    where: {
      email: req.query.email,
    },
    attributes: ['email']
  }).then(user => {
    res.status(200).send(!!user);
  }).catch(err => {
    console.error("Error while validating email:", err);
    res.status(500).send({
      message: err.message || "Some error occurred while validating email"
    });
  });
}