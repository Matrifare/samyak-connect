const { DataTypes, sequelize } = require('sequelize');

module.exports = (sequelize) => {

    return sequelize.define("message",
    {    
      msg_id:{
        type: DataTypes.INTEGER,
        allowNull: false,
        primaryKey: true,    
      },
      msg_to:{
        type: DataTypes.STRING(150),
        allowNull: false
      },
      msg_from:{
        type: DataTypes.STRING(150),
        allowNull: false
      },
      msg_subject:{
        type: DataTypes.TEXT,
        allowNull: false
      },
      msg_content:{
        type: DataTypes.TEXT,
        allowNull: false
      },
      msg_status: {
        type: DataTypes.ENUM('draft', 'sent', 'trash'),
      },
      msg_read_status: {
        type: DataTypes.ENUM('Yes', 'No'),
      },
      msg_important_status: {
        type: DataTypes.ENUM('Yes', 'No'),
      },
      msg_date: {
        type: DataTypes.DATE,
      },
      trash_sender: {
        type: DataTypes.ENUM('Yes', 'No'),
      },
      trash_receiver: {
        type: DataTypes.ENUM('Yes', 'No'),
      },
    },
      {
        freezeTableName: true,
        timestamps: false,
      }
    )

};