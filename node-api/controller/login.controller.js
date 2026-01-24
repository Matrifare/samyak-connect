const axios = require("axios");
const passwordGenerator = require("otp-generator");
const jwt = require("jsonwebtoken");

//authenticate
module.exports.authenticate = (req, res) => {
  const username = req.body.username;
  const password = req.body.password;
  const { db } = require("../database.js");
  const Register = db.registers;
  const { Op } = require("sequelize");
  const crypto = require("crypto");
  const hash = crypto.createHash("md5").update(password).digest("hex");

  Register.scope("withPassword")
    .findOne({
      where: {
        //validating username
        [Op.or]: [
          {
            email: username,
          },
          {
            matri_id: username,
          },
        ],
      },
    })
    .then((user) => {
      if (user && user.dataValues) {
        const userData = user.dataValues;
        if (hash === userData.password) {
          req.session.userId = userData.matri_id;
          req.session.gender = userData.gender;
          jwt.sign(
            { user: userData },
            "secretkey",
            { expiresIn: "24h" }, // Changed from "60s" to "24h" for production use
            (err, token) => {
              //user.token = {token};
              res.status(200).send({ token, matri_id: userData.matri_id });
            }
          );
        } else {
          res.status(401).send({
            message: "unauthorized",
          });
        }
      } else {
        res.status(404).send({
          message: "user not found",
        });
      }
    })
    .catch((err) => {
      console.error("Error while authenticating user:", err);
      res.status(500).send({
        message: err.message || "Some error occurred while login",
      });
    });
};

module.exports.resetPassword = (req, res) => {
  const email = req.body.email;
  const mobileNumber = req.body.mobileNumber;
  const { db } = require("../database.js");

  const SmsTemp = db.smstemp;
  const generatedPassword = passwordGenerator.generate(8, {
    upperCase: true,
    specialChars: true,
    alphabets: true,
  });
  console.log("generatedPassword", generatedPassword);

  SmsTemp.findOne({
    where: { temp_name: "Change Password", status: "APPROVED" },
  })
    .then((template) => {
      const { temp_value } = template;
      const message = temp_value.replace("*password*", generatedPassword);
      sendResetPasswordMessage(mobileNumber, message);
      const Register = db.registers;
      const crypto = require("crypto");
      const hash = crypto
        .createHash("md5")
        .update(generatedPassword)
        .digest("hex");
      Register.update({ password: hash }, { where: { email } })
        .then(() => {
          res.send({ message: "Password reset successfully." });
          console.log(
            `Register password was updated successfully for email ${email}.`
          );
        })
        .catch((err) => {
          console.error(
            `Error while updating Register password for email ${email}:`,
            err
          );
          res.status(500).send({
            message:
              err.message || `Error while fetching register for email ${email}`,
          });
        });
    })
    .catch((err) => {
      console.error("Error while fetching Change Password sms template:", err);
      res.status(500).send({
        message:
          err.message ||
          "Error occurred while retrieving Change Password sms templates.",
      });
    });
};

const SEND_OTP_URL = "http://www.smscountry.com/SMSCwebservice_Bulk.aspx";

function sendResetPasswordMessage(mobileNumber, message) {
  const user = "matrifare";
  const password = "preview";
  const senderId = "SMYKOL";
  const messageToSend = encodeURI(message);
  const url =
    SEND_OTP_URL +
    "?User=" +
    user +
    "&passwd=" +
    password +
    "&mobileNumber=" +
    mobileNumber +
    "&message=" +
    messageToSend +
    "&sid=" +
    senderId +
    "&DR=Y&mtype=N";
  console.log(message);
  console.log(url);
  axios
    .post(url)
    .then(() => {
      console.log("Password sent succefully");
    })
    .catch((error) => {
      console.error("Error while sending password reset message:", error);
      console.error(error.response);
    });
}
