module.exports = app => {

    const expressinterestprivacy = require("../controller/expressinterestprivacy.controller.js");
    var router = require("express").Router();
  
    // create express interest privacy
    router.post("/", expressinterestprivacy.create);
  
    // update express interest privacy
    router.post("/update", expressinterestprivacy.update);
      
    //get all by query
    router.get("/query", expressinterestprivacy.findByQuery);
  
    app.use('/api/expressinterestprivacy', router);
  };