const { DataTypes, sequelize } = require("sequelize");

module.exports = (sequelize) => {
  return sequelize.define(
    "register_view",
    {
      index_id: {
        type: DataTypes.INTEGER,
        allowNull: false,
        primaryKey: true
      },
      fb_id: {
        type: DataTypes.INTEGER,
        allowNull: true,
      },
      samyak_id: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      matri_id: {
        type: DataTypes.STRING,
        allowNull: false,
      },
      prefix: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      terms: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      email: {
        type: DataTypes.STRING,
        allowNull: false,
      },
      password: {
        type: DataTypes.STRING,
        allowNull: false,
      },
      cpassword: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      cpass_status: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      m_status: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      profileby: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      time_to_call: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      reference: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      username: {
        type: DataTypes.STRING,
        allowNull: false,
      },
      firstname: {
        type: DataTypes.STRING,
        allowNull: false,
      },
      lastname: {
        type: DataTypes.STRING,
        allowNull: false,
      },
      gender: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      birthdate: {
        type: DataTypes.DATEONLY,
        allowNull: true,
      },
      birthtime: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      birthplace: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      tot_children: {
        type: DataTypes.INTEGER,
        allowNull: true,
      },
      status_children: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      e_level: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      e_field: {
        type: DataTypes.INTEGER,
        allowNull: true,
      },
      part_edu_level: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      part_edu_field: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      edu_detail: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      income: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      monthly_sal: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      occupation: {
        type: DataTypes.INTEGER,
        allowNull: true,
      },
      emp_in: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      designation: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      other_caste: {
        type: DataTypes.INTEGER,
        allowNull: true,
      },
      religion: {
        type: DataTypes.INTEGER,
        allowNull: true,
      },
      caste: {
        type: DataTypes.INTEGER,
        allowNull: true,
      },
      subcaste: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      gothra: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      star: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      moonsign: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      horoscope: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      manglik: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      m_tongue: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      height: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      weight: {
        type: DataTypes.INTEGER,
        allowNull: true,
      },
      b_group: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      complexion: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      bodytype: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      diet: {
        type: DataTypes.STRING,
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
        type: DataTypes.STRING,
        allowNull: true,
      },
      address: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      country_id: {
        type: DataTypes.INTEGER,
        allowNull: true,
      },
      state_id: {
        type: DataTypes.INTEGER,
        allowNull: true,
      },
      house_ownership: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      living_status: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      city: {
        type: DataTypes.INTEGER,
        allowNull: true,
      },
      phone: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      mobile: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      contact_view_security: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      disability: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      residence: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      father_name: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      mother_name: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      father_living_status: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      mother_living_status: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      father_occupation: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      mother_occupation: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      profile_text: {
        type: DataTypes.TEXT,
        allowNull: true,
      },
      looking_for: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      family_origin: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      family_value: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      family_details: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      family_type: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      family_status: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      no_of_brothers: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      no_of_sisters: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      no_marri_brother: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      no_marri_sister: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      part_frm_age: {
        type: DataTypes.INTEGER,
        allowNull: true,
      },
      part_to_age: {
        type: DataTypes.INTEGER,
        allowNull: true,
      },
      part_bodytype: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      part_diet: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      part_smoke: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      part_drink: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      part_income: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      part_emp_in: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      part_occupation: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      part_designation: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      part_expect: {
        type: DataTypes.TEXT,
        allowNull: true,
      },
      part_height: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      part_height_to: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      part_complexion: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      part_mtongue: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      part_religion: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      part_caste: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      part_manglik: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      part_star: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      part_edu: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      part_country_living: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      part_state: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      part_city: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      part_resi_status: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      part_native_place: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      photo1: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      photo1_status: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      photo2: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      photo2_status: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      photo3: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      photo3_status: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      photo4: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      photo4_status: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      video: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      video_status: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      status: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      fstatus: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      logged_in: {
        type: DataTypes.INTEGER,
        allowNull: true,
      },
      adminrole_id: {
        type: DataTypes.INTEGER,
        allowNull: true,
      },
      franchised_by: {
        type: DataTypes.INTEGER,
        allowNull: true,
      },
      adminrole_view_status: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      mobile_verify_status: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      email_verify_status: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      view_profile_condition: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      send_interest_condition: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      reg_date: {
        type: DataTypes.DATE,
        allowNull: false,
      },
      last_login: {
        type: DataTypes.DATE,
        allowNull: true,
      },
      ip: {
        type: DataTypes.STRING,
        allowNull: true,
      },
      agent: {
        type: DataTypes.STRING,
        allowNull: true,
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
