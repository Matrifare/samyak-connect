module.exports = app => {

    const emailTemp = require("../controller/email_templates.controller.js");
    var router = require("express").Router();

    //get all approved email templates
    router.get("/approved",emailTemp.findAllApproved);
    //get all approved by template name
    router.get("/",emailTemp.findAllByName);
    //get all by query
    router.get("/query",emailTemp.findByQuery);

    app.use('/api/email_templates', router);
};