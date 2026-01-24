const { DataTypes, sequelize } = require('sequelize');

module.exports = (sequelize) => {

    return sequelize.define("membership_plan",
    {    
      plan_id:{
        type: DataTypes.INTEGER,
        allowNull: false,
        primaryKey: true,    
      },
      plan_name:{
        type: DataTypes.TEXT,
        allowNull: false
      },
      plan_type:{
        type: DataTypes.TEXT,
        allowNull: false
      },
      plan_amount:{
        type: DataTypes.DOUBLE,
        allowNull: false
      },
      plan_amount_type:{
        type: DataTypes.TEXT,
        allowNull: false
      },
      plan_duration:{
        type: DataTypes.INTEGER,
        allowNull: false
      },
      plan_contacts:{
        type: DataTypes.INTEGER,
        allowNull: false
      },
      profile:{
        type: DataTypes.INTEGER,
        allowNull: false
      },
      plan_msg:{
        type: DataTypes.INTEGER,
        allowNull: false
      },
      interest_per_day:{
        type: DataTypes.INTEGER,
        allowNull: false
      },
      profile_view_per_day:{
        type: DataTypes.INTEGER,
        allowNull: false
      },
      plan_image:{
        type: DataTypes.TEXT,
        allowNull: true
      },
      plan_link:{
        type: DataTypes.STRING(500),
        allowNull: true
      },
      plan_offers:{
        type: DataTypes.STRING(200),
        allowNull: true
      },
      video: {
        type: DataTypes.ENUM('Yes', 'No'),
      },
      chat: {
        type: DataTypes.ENUM('Yes', 'No'),
      },
      status: {
        type: DataTypes.ENUM('APPROVED', 'UNAPPROVED'),
      },
    },
      {
        freezeTableName: true,
        timestamps: false,
      }
    )

};