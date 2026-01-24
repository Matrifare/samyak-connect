const { db } = require("../database.js");
const { QueryTypes } = require("sequelize")
const Contactchecker = db.contactCheck;
const seq = db.sequelize;

//find all by my_id
module.exports.findByMyId = (req, res) => {
  const myId = req.query.my_id;
  console.log(myId);
  Contactchecker.findAll({ where: { my_id: myId } })
    .then(data => {
      res.send(data);
    })
    .catch(err => {
      console.error("Error in findByMyId:", err);
      res.status(500).send({
        message:
          err.message || "Error occurred while retrieving contact_checker by my id"
      });
    });
}

//creaet contact_checker
module.exports.createContactChecker = (req, res) => {
  // Validate request
  if (!req.body.my_id) {
    res.status(400).send({
      message: "Content can not be empty!"
    });
    return;
  }

  // Create a contact_checker
  const contactChecker = {
    my_id: req.body.my_id,
    viewed_id: req.body.viewed_id,
    date: req.body.date,
    ip_address: req.body.ip_address,
  };

  // Save contact_checker in the database
  Contactchecker.create(contactChecker)
    .then(data => {
      res.send(data);
    })
    .catch(err => {
      console.error("Error in createContactChecker:", err);
      res.status(500).send({
        message:
          err.message || "Some error occurred while creating the contact_checker."
      });
    });
};


//check contact counts and payment plan
module.exports.contactChecker = async (req, res) => {

  var sql = "select r.*,p.p_no_contacts, p.r_cnt,p.exp_date,p.p_plan from register_view r JOIN payment_view p ON r.matri_id=p.pmatri_id where pmatri_id=" + req.query.matri_id;

  await seq
    .query(sql, {
      logging: console.log,
      plain: false,
      raw: true,
      type: QueryTypes.SELECT,
    })
    .then((data) => {
      res.send(data);
    })
    .catch((err) => {
      console.error("Error while fetching contact counts and payment plan:", err);
      res.status(500).send({
        message: "Error while fetching recentpremium",
      });
    });

};

//check contact details already seen
module.exports.getContacts = async (req, res) => {

  var sql = "select * from contact_checker where my_id=" + req.query.matri_id + " and viewed_id=" + req.query.from_id;

  await seq
    .query(sql, {
      logging: console.log,
      plain: false,
      raw: true,
      type: QueryTypes.SELECT,
    })
    .then((data) => {
      res.send(data);
    })
    .catch((err) => {
      console.error("Error while fetching contact details:", err);
      res.status(500).send({
        message: "Error while fetching recentpremium",
      });
    });

};

//check contact security
module.exports.contactSecurity = async (req, res) => {

  var sql = "select * from register_view r INNER JOIN payment_view p ON r.matri_id=p.pmatri_id where r.matri_id=" + req.query.from_id;

  await seq
    .query(sql, {
      logging: console.log,
      plain: false,
      raw: true,
      type: QueryTypes.SELECT,
    })
    .then((data) => {
      res.send(data);
    })
    .catch((err) => {
      console.error("Error while fetching contact security:", err);
      res.status(500).send({
        message: "Error while fetching contact security",
      });
    });

};

//seen contacts
module.exports.seenContacts = async (req, res) => {

  var sql = "SELECT count(my_id) as seenCount FROM contact_checker where my_id=" + req.query.matri_id + " and date(date)=" + date('YYYY-mm-dd');

  await seq
    .query(sql, {
      logging: console.log,
      plain: false,
      raw: true,
      type: QueryTypes.SELECT,
    })
    .then((data) => {
      res.send(data);
    })
    .catch((err) => {
      console.error("Error in seenContacts:", err);
      res.status(500).send({
        message: "Error while fetching seenContacts",
      });
    });

};

// Get contact views per day
module.exports.contactViewsPerDay = async (req, res) => {
  const { my_id } = req.query;
  const today = moment().format("YYYY-MM-DD");

  const sql = `
    SELECT COUNT(*) as viewCount FROM contact_checker
    WHERE my_id = :my_id AND DATE(date) = :today
  `;

  await seq
    .query(sql, {
      replacements: { my_id, today },
      logging: console.log,
      plain: true,
      raw: true,
      type: QueryTypes.SELECT,
    })
    .then((data) => {
      res.send(data);
    })
    .catch((err) => {
      console.error("Error while fetching contact views per day:", err);
      res.status(500).send({
        message: "Error while fetching contact views per day",
      });
    });
};

// Update or insert contact checker entry
module.exports.updateContactChecker = async (req, res) => {
  const { my_id, viewed_id } = req.body;
  const date = moment().format("YYYY-MM-DD HH:mm:ss");

  const checkSql = `
    SELECT * FROM contact_checker
    WHERE my_id = :my_id AND viewed_id = :viewed_id
  `;

  const updateSql = `
    UPDATE contact_checker
    SET date = :date
    WHERE my_id = :my_id AND viewed_id = :viewed_id
  `;

  const insertSql = `
    INSERT INTO contact_checker (my_id, viewed_id, date)
    VALUES (:my_id, :viewed_id, :date)
  `;

  try {
    const existingEntry = await seq.query(checkSql, {
      replacements: { my_id, viewed_id },
      logging: console.log,
      plain: true,
      raw: true,
      type: QueryTypes.SELECT,
    });

    if (existingEntry) {
      await seq.query(updateSql, {
        replacements: { my_id, viewed_id, date },
        logging: console.log,
        plain: false,
        raw: true,
        type: QueryTypes.UPDATE,
      });
      res.send({ message: "Contact checker updated successfully." });
    } else {
      await seq.query(insertSql, {
        replacements: { my_id, viewed_id, date },
        logging: console.log,
        plain: false,
        raw: true,
        type: QueryTypes.INSERT,
      });
      res.send({ message: "Contact checker recorded successfully." });
    }
  } catch (err) {
    console.error("Error while adding or updating contact checker:", err);
    res.status(500).send({
      message: "Error while adding or updating contact checker",
    });
  }
};
