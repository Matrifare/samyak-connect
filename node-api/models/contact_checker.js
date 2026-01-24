const { DataTypes, sequelize } = require('sequelize');

module.exports = (sequelize) => {

    return sequelize.define("contact_checker",
    {    
      id:{
        type: DataTypes.INTEGER,
        allowNull: false,
        primaryKey: true,    
      },
      my_id:{
        type: DataTypes.STRING,
        allowNull: true
      },
      viewed_id:{
        type: DataTypes.STRING,
        allowNull: true
      },
      date:{
        type: DataTypes.DATE,
        allowNull: false
      },
      ip_address:{
          type: DataTypes.STRING(16),
          allowNull: false
      }
    },
      {
        freezeTableName: true,
        timestamps: false,
      }
    )

};