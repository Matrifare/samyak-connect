module.exports = app => {

  const smsUtils = require("../controller/sms_utils.controller.js");
  var router = require("express").Router();

  // Generate and send OTP to frontend and the provided mobile number
  router.get("/mobileVerification", smsUtils.mobileVerification);

  app.use('/api/sms', router);
};