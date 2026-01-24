const { DataTypes, sequelize } = require('sequelize');

module.exports = (sequelize) => {

    return sequelize.define("country",
    {    
      country_id:{
        type: DataTypes.INTEGER,
        allowNull: false,
        primaryKey: true,    
      },
      country_code:{
        type: DataTypes.STRING(8),
        allowNull: true
      },
      country_name:{
        type: DataTypes.STRING(255),
        allowNull: true
      },
      status:{
        type: DataTypes.STRING,
        allowNull: false
      }
    },
      {
        freezeTableName: true,
        timestamps: false,
      }
    )

};