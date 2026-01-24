const { DataTypes, sequelize } = require('sequelize');

module.exports = (sequelize) => {

    return sequelize.define("payments",
    {    
      payid:{
        type: DataTypes.INTEGER,
        allowNull: false,
        primaryKey: true,    
      },
      pmatri_id:{
        type: DataTypes.TEXT(50),
        allowNull: false
      },
      pname:{
        type: DataTypes.TEXT,
        allowNull: false
      },
      pemail:{
        type: DataTypes.TEXT,
        allowNull: false
      },
      pmobile:{
        type: DataTypes.TEXT,
        allowNull: true
      },
      paymode:{
        type: DataTypes.TEXT,
        allowNull: false
      },
      pactive_dt:{
        type: DataTypes.TEXT,
        allowNull: false
      },
      plan_duration:{
        type: DataTypes.INTEGER,
        allowNull: false
      },
      profile:{
        type: DataTypes.INTEGER,
        allowNull: false
      },
      video: {
        type: DataTypes.ENUM('Yes', 'No'),
      },
      chat: {
        type: DataTypes.ENUM('Yes', 'No'),
      },
      p_no_contacts:{
        type: DataTypes.INTEGER,
        allowNull: false
      },
      p_plan: {
        type: DataTypes.TEXT(100),
        allowNull: false
      },
      p_amount:{
        type: DataTypes.INTEGER,
        allowNull: false
      },
      p_bank_detail:{
        type: DataTypes.TEXT,
        allowNull: false
      },
      pay_id:{
        type: DataTypes.TEXT,
        allowNull: true
      },
      p_msg:{
        type: DataTypes.INTEGER,
        allowNull: false
      },
      r_profile:{
        type: DataTypes.INTEGER,
        allowNull: false
      },
      r_cnt:{
        type: DataTypes.INTEGER,
        allowNull: false
      },
      r_sms:{
        type: DataTypes.INTEGER,
        allowNull: false
      },
      exp_date:{
        type: DataTypes.TEXT,
        allowNull: false
      },
      current_plan:{
        type: DataTypes.ENUM('Yes', 'No'),
      },
    },
      {
        freezeTableName: true,
        timestamps: false,
      }
    )

};