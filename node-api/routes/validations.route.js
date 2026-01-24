module.exports = app => {

  const validations = require("../controller/validations.controller.js");
  var router = require("express").Router();

  // check email exists or not
  router.get("/checkEmail", validations.checkEmail);

  app.use('/api/validations', router);
};