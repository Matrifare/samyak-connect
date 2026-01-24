const { db } = require('../database.js');
const otpGenerator = require('otp-generator');
const axios = require('axios');

const SmsTemp = db.smstemp;

const SEND_OTP_URL = 'http://www.smscountry.com/SMSCwebservice_Bulk.aspx';

module.exports.mobileVerification = (req, res) => {
  // First retrieve Mobile Verification sms template
  SmsTemp.findOne({ where: { temp_name: 'Mobile Verification', status: 'APPROVED' } })
    .then(template => {
      const { temp_value } = template;
      const mobileNumber = req.query.mobileNumber;
      // generate 4 digit OTP
      const OTP = `${Math.random()}`.slice("-4")
      console.log("OTP", OTP);
      const message = temp_value.replace('*', OTP);
      sendOTPMessage(mobileNumber, message);
      res.send(OTP);
    })
    .catch(err => {
      console.error("Error while fetching Mobile Verification sms template:", err);
      res.status(500).send({
        message:
          err.message || "Error occurred while retrieving Mobile Verification sms templates."
      });
    })
}

function sendOTPMessage(mobileNumber, message) {
  const user = 'matrifare';
  const password = 'preview';
  const senderId = 'SMYKOL';
  const messageToSend = encodeURI(message);
  const url = SEND_OTP_URL+"?User="+user+"&passwd="+password+"&mobileNumber="+mobileNumber+"&message="+messageToSend+"&sid="+senderId+"&DR=Y&mtype=N";
  console.log(message);
  console.log(url)
  axios.post(url)
  .then(() => {
    console.log("OTP sent succefully");
  }).catch(error => {
    console.error("Error while sending OTP message:", error);
  })
}