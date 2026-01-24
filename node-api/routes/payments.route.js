module.exports = app => {
  const payment = require("../controller/payments.controller.js");
  var router = require("express").Router();

  //create payment
  router.post("/",payment.create);

  //update payment
  router.put("/", payment.update);

  //get all payments by query
  router.get("/query",payment.findByQuery);
      
  //find plan by matri_id
  router.get("/:matri_id", payment.findOne);

  app.use('/api/payments', router);
};