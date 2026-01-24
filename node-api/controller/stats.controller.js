const StatsService = require('../services/stats.service');

class StatsController {
  constructor() {
    this.statsService = StatsService;
  }

  async getOverallStats(req, res) {
    try {
      const stats = await this.statsService.getOverallStats();
      res.status(200).json(stats);
    } catch (error) {
      console.error('Error fetching overall stats:', error);
      res.status(500).json({ error: 'Internal server error' });
    }
  }

  getUserStats = async (req, res) => {
    try {
      const userId = req.params.userId;
      const userEmail = req.query.email; // Assuming email is passed as a query parameter

      const userStats = await this.statsService.getUserStats(userId, userEmail);

      res.status(200).json(userStats);
    } catch (error) {
      console.error('Error fetching user stats:', error);
      res.status(500).json({ error: 'Internal server error' });
    }
  }

  async getDailyStats(req, res) {
    try {
      const date = req.query.date || new Date().toISOString().split('T')[0];
      const dailyStats = await this.statsService.getDailyStats(date);
      res.status(200).json(dailyStats);
    } catch (error) {
      console.error('Error fetching daily stats:', error);
      res.status(500).json({ error: 'Internal server error' });
    }
  }
}

module.exports = new StatsController();
