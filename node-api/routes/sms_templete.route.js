module.exports = app => {

    const smsTemp = require("../controller/sms_templete.controller.js");
    var router = require("express").Router();

    //get all approved sms templates
    router.get("/approved",smsTemp.findAllApproved);
    //get all approved by template name
    router.get("/",smsTemp.findAllByName);
    //get all by query
    router.get("/query",smsTemp.findByQuery);

    app.use('/api/sms_template', router);
};