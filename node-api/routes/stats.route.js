module.exports = (app) => {
  const stats = require("../controller/stats.controller.js");
  var router = require("express").Router();

  router.get('/', stats.getOverallStats);
  router.get('/user/:userId', stats.getUserStats);

  app.use("/api/stats", router);
};
