const { DataTypes, sequelize } = require('sequelize');

module.exports = (sequelize) => {
    return sequelize.define("expressinterest",
    {    
      ei_id:{
        type: DataTypes.INTEGER,
        allowNull: false,
        primaryKey: true,    
      },
      ei_sender:{
        type: DataTypes.STRING(50),
        allowNull: false
      },
      ei_receiver:{
        type: DataTypes.STRING(50),
        allowNull: false
      },
      receiver_response:{
        type: DataTypes.ENUM('Pending','Accept','Reject','Inactive','Hold','SuspendedPending','SuspendedAccept','SuspendedReject','SuspendedHold'),
        allowNull: true
      },
      receiver_response_date:{
        type: DataTypes.DATE,
        allowNull: true
      },
      ei_message:{
        type: DataTypes.STRING(1000),
        allowNull: false
      },
      ei_sent_date:{
        type: DataTypes.DATE,
        allowNull: false
      },
      status:{
        type: DataTypes.ENUM('UNAPPROVED','APPROVED'),
        allowNull: false
      },
      trash_receiver:{
        type: DataTypes.ENUM('No','Yes'),
        allowNull: false
      },
      trash_sender:{
        type: DataTypes.ENUM('No','Yes'),
        allowNull: false
      },
    },
      {
        freezeTableName: true,
        timestamps: false,
      }
    )

};