const { DataTypes, sequelize } = require("sequelize");

module.exports = (sequelize) => {
  return sequelize.define(
    "register",
    {
      index_id: {
        type: DataTypes.INTEGER,
        allowNull: false,
        primaryKey: true,
      },
      fb_id: {
        type: DataTypes.INTEGER,
        allowNull: true,
      },
      matri_id: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      samyak_id: {
        type: DataTypes.STRING(10),
        allowNull: true,
      },
      prefix: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      title: {
        type: DataTypes.STRING(500),
        allowNull: true,
      },
      description: {
        type: DataTypes.STRING(500),
        allowNull: true,
      },
      keyword: {
        type: DataTypes.STRING(500),
        allowNull: true,
      },
      terms: {
        type: DataTypes.STRING(10),
        allowNull: false,
      },
      email: {
        type: DataTypes.STRING(255),
        allowNull: true,
      },
      password: {
        type: DataTypes.STRING(300),
        allowNull: true,
      },
      cpassword: {
        type: DataTypes.STRING(255),
        allowNull: true,
      },
      cpass_status: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      m_status: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      profileby: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      time_to_call: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      reference: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      username: {
        type: DataTypes.STRING(100),
        allowNull: true,
      },
      firstname: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      lastname: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      gender: {
        type: DataTypes.STRING(100),
        allowNull: true,
      },
      birthdate: {
        type: DataTypes.DATE,
        allowNull: true,
      },
      birthtime: {
        type: DataTypes.STRING(15),
        allowNull: true,
      },
      birthplace: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      tot_children: {
        type: DataTypes.STRING(100),
        allowNull: true,
      },
      status_children: {
        type: DataTypes.STRING(100),
        allowNull: true,
      },
      education_level: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      education_field: {
        type: DataTypes.INTEGER(11),
        allowNull: true,
      },
      edu_detail: {
        type: DataTypes.STRING(100),
        allowNull: true,
      },
      income: {
        type: DataTypes.STRING(100),
        allowNull: true,
      },
      occupation: {
        type: DataTypes.STRING(100),
        allowNull: true,
      },
      emp_in: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      monthly_sal: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      designation: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      other_caste: {
        type: DataTypes.TINYINT(2),
        allowNull: true,
      },
      religion: {
        type: DataTypes.INTEGER(11),
        allowNull: true,
      },
      caste: {
        type: DataTypes.INTEGER(11),
        allowNull: true,
      },
      subcaste: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      gothra: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      star: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      moonsign: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      horoscope: {
        type: DataTypes.STRING(255),
        allowNull: true,
      },
      manglik: {
        type: DataTypes.STRING(200),
        allowNull: true,
      },
      m_tongue: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      height: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      weight: {
        type: DataTypes.INTEGER(11),
        allowNull: true,
      },
      b_group: {
        type: DataTypes.STRING(100),
        allowNull: true,
      },
      disability: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      complexion: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      bodytype: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      diet: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      smoke: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      drink: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      languages_known: {
        type: DataTypes.STRING(150),
        allowNull: true,
      },
      address: {
        type: DataTypes.TEXT,
        allowNull: true,
      },
      country_id: {
        type: DataTypes.INTEGER(11),
        allowNull: true,
      },
      state_id: {
        type: DataTypes.INTEGER(11),
        allowNull: true,
      },
      city: {
        type: DataTypes.INTEGER(11),
        allowNull: true,
      },
      phone: {
        type: DataTypes.STRING(25),
        allowNull: true,
      },
      mobile: {
        type: DataTypes.STRING(60),
        allowNull: true,
      },
      contact_view_security: {
        type: DataTypes.STRING(20),
        allowNull: true,
      },
      residence: {
        type: DataTypes.STRING(500),
        allowNull: true,
      },
      living_status: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      house_ownership: {
        type: DataTypes.STRING(100),
        allowNull: true,
      },
      father_name: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      mother_name: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      father_living_status: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      mother_living_status: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      father_occupation: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      mother_occupation: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      profile_text: {
        type: DataTypes.TEXT,
        allowNull: true,
      },
      looking_for: {
        type: DataTypes.STRING(500),
        allowNull: true,
      },
      family_origin: {
        type: DataTypes.STRING(20),
        allowNull: true,
      },
      family_details: {
        type: DataTypes.STRING(1000),
        allowNull: true,
      },
      family_value: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      family_type: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      family_status: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      no_of_brothers: {
        type: DataTypes.STRING(20),
        allowNull: true,
      },
      no_of_sisters: {
        type: DataTypes.STRING(20),
        allowNull: true,
      },
      no_marri_brother: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      no_marri_sister: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      part_frm_age: {
        type: DataTypes.INTEGER(2),
        allowNull: true,
      },
      part_to_age: {
        type: DataTypes.INTEGER(2),
        allowNull: true,
      },
      part_bodytype: {
        type: DataTypes.STRING(700),
        allowNull: true,
      },
      part_diet: {
        type: DataTypes.STRING(200),
        allowNull: true,
      },
      part_smoke: {
        type: DataTypes.STRING(200),
        allowNull: true,
      },
      part_drink: {
        type: DataTypes.STRING(200),
        allowNull: true,
      },
      part_income: {
        type: DataTypes.STRING(100),
        allowNull: true,
      },
      part_emp_in: {
        type: DataTypes.STRING(500),
        allowNull: true,
      },
      part_occupation: {
        type: DataTypes.STRING(500),
        allowNull: true,
      },
      part_designation: {
        type: DataTypes.STRING(700),
        allowNull: true,
      },
      part_expect: {
        type: DataTypes.STRING(1000),
        allowNull: true,
      },
      part_height: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      part_height_to: {
        type: DataTypes.STRING(100),
        allowNull: true,
      },
      part_complexion: {
        type: DataTypes.STRING(500),
        allowNull: true,
      },
      part_mtongue: {
        type: DataTypes.STRING(700),
        allowNull: true,
      },
      part_religion: {
        type: DataTypes.STRING(700),
        allowNull: true,
      },
      part_caste: {
        type: DataTypes.STRING(700),
        allowNull: true,
      },
      part_manglik: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      part_star: {
        type: DataTypes.STRING(700),
        allowNull: true,
      },
      part_edu: {
        type: DataTypes.STRING(700),
        allowNull: true,
      },
      part_edu_level: {
        type: DataTypes.STRING(400),
        allowNull: true,
      },
      part_edu_field: {
        type: DataTypes.STRING(100),
        allowNull: true,
      },
      part_country_living: {
        type: DataTypes.STRING(700),
        allowNull: true,
      },
      part_state: {
        type: DataTypes.STRING(700),
        allowNull: true,
      },
      part_city: {
        type: DataTypes.STRING(700),
        allowNull: true,
      },
      part_resi_status: {
        type: DataTypes.STRING(500),
        allowNull: true,
      },
      part_native_place: {
        type: DataTypes.STRING(100),
        allowNull: true,
      },
      hobby: {
        type: DataTypes.TEXT,
        allowNull: true,
      },
      hor_check: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      hor_photo: {
        type: DataTypes.STRING(255),
        allowNull: true,
      },
      photo_protect: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      photo_pswd: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      video: {
        type: DataTypes.TEXT,
        allowNull: true,
      },
      video_approval: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      video_url: {
        type: DataTypes.TEXT,
        allowNull: true,
      },
      video_view_status: {
        type: DataTypes.STRING(5),
        allowNull: true,
      },
      photo_view_status: {
        type: DataTypes.STRING(5),
        allowNull: true,
      },
      photo1: {
        type: DataTypes.STRING(255),
        allowNull: true,
      },
      photo1_approve: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      photo1_update_date: {
        type: DataTypes.DATE,
        allowNull: true,
      },
      photo2: {
        type: DataTypes.STRING(255),
        allowNull: true,
      },
      photo2_approve: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      photo3: {
        type: DataTypes.STRING(255),
        allowNull: true,
      },
      photo3_approve: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      photo4: {
        type: DataTypes.STRING(255),
        allowNull: true,
      },
      photo4_approve: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      photo5: {
        type: DataTypes.STRING(255),
        allowNull: true,
      },
      photo5_approve: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      photo6: {
        type: DataTypes.STRING(255),
        allowNull: true,
      },
      photo6_approve: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      photo7: {
        type: DataTypes.STRING(255),
        allowNull: true,
      },
      photo7_approve: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      photo8: {
        type: DataTypes.STRING(255),
        allowNull: true,
      },
      photo8_approve: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      reg_date: {
        type: DataTypes.DATE,
        allowNull: true,
      },
      ip: {
        type: DataTypes.STRING(30),
        allowNull: true,
      },
      agent: {
        type: DataTypes.TEXT,
        allowNull: true,
      },
      agent_approve: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      last_login: {
        type: DataTypes.DATE,
        allowNull: true,
      },
      status: {
        type: DataTypes.STRING(50),
        allowNull: false,
      },
      fstatus: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      logged_in: {
        type: DataTypes.STRING(5),
        allowNull: true,
      },
      adminrole_id: {
        type: DataTypes.INTEGER(11),
        allowNull: true,
      },
      franchised_by: {
        type: DataTypes.STRING(50),
        allowNull: true,
      },
      adminrole_view_status: {
        type: DataTypes.STRING(5),
        allowNull: false,
      },
      mobile_verify_status: {
        type: DataTypes.STRING(5),
        allowNull: false,
      },
      email_verify_status: {
        type: DataTypes.STRING(5),
        allowNull: false,
      },
    },
    {
      freezeTableName: true,
      timestamps: false,
      defaultScope: {
        attributes: { exclude: ["password"] },
      },
      scopes: {
        withPassword: {
          attributes: {},
        },
      },
    }
  );
};
