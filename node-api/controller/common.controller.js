//retrive by query with limited or all attributes
module.exports.findByQuery = (table, req,res) => {
    let { attributes = '', ...query } = req.query;
    console.log("Find by ", JSON.stringify(query), "With attributes", attributes || 'All');
    const options = {};
    options.where = query;
    if (attributes) {
      attributes = attributes.split(',');
      options.attributes = attributes;
    }
    console.log("options", options);
    table.findAll(options).then(data => {
      // console.log(data);
      res.send(data);
    }).catch(err => {
      console.error("Error while fetching data:", err);
       res.status(500).send({
         message: err.message || "some error occurred while fetching data"
       });
    });
  };