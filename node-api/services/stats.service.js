const ExpressInterestController = require('../controller/expressinterest.controller');
const MessageController = require('../controller/message.controller');
const ShowMoreProfilesController = require('../controller/showmoreprofiles.controller');

class StatsService {
  async getUserStats(userId, userEmail) {
    // Fetch data from ExpressInterest controller
    const sentPending = await new Promise((resolve) => ExpressInterestController.sentPending({ query: { matri_id: userId } }, { send: resolve }));
    const sentAccepted = await new Promise((resolve) => ExpressInterestController.sentAccepted({ query: { matri_id: userId } }, { send: resolve }));
    const sentRejected = await new Promise((resolve) => ExpressInterestController.sentRejected({ query: { matri_id: userId } }, { send: resolve }));
    const receivedPending = await new Promise((resolve) => ExpressInterestController.receivedPending({ query: { matri_id: userId } }, { send: resolve }));
    const receivedAccepted = await new Promise((resolve) => ExpressInterestController.receivedAccepted({ query: { matri_id: userId } }, { send: resolve }));
    const receivedRejected = await new Promise((resolve) => ExpressInterestController.receivedRejected({ query: { matri_id: userId } }, { send: resolve }));

    // Fetch data from Message controller
    const receivedMessages = await new Promise((resolve) => MessageController.receivedMessages({ query: { email: userEmail } }, { send: resolve }));
    const sentMessages = await new Promise((resolve) => MessageController.sentMessages({ query: { email: userEmail } }, { send: resolve }));

    // Fetch data from ShowMoreProfiles controller
    const bookmarks = await new Promise((resolve) => ShowMoreProfilesController.bookmark({ query: { matri_id: userId } }, { send: resolve }));
    const viewed = await new Promise((resolve) => ShowMoreProfilesController.viewed({ query: { matri_id: userId } }, { send: resolve }));
    const visitors = await new Promise((resolve) => ShowMoreProfilesController.visitor({ query: { matri_id: userId } }, { send: resolve }));
    const blockedProfiles = await new Promise((resolve) => ShowMoreProfilesController.block({ query: { matri_id: userId } }, { send: resolve }));
    const viewedContacts = await new Promise((resolve) => ShowMoreProfilesController.viewedcontacts({ query: { matri_id: userId } }, { send: resolve }));
    const viewedMyContacts = await new Promise((resolve) => ShowMoreProfilesController.viewedmycontacts({ query: { matri_id: userId } }, { send: resolve }));
    const shortlisted = await new Promise((resolve) => ShowMoreProfilesController.shortlisted({ query: { matri_id: userId } }, { send: resolve }));

    return {
      expressInterest: {
        sent: {
          pending: sentPending.length,
          accepted: sentAccepted.length,
          rejected: sentRejected.length,
        },
        received: {
          pending: receivedPending.length,
          accepted: receivedAccepted.length,
          rejected: receivedRejected.length,
        },
      },
      messages: {
        received: receivedMessages.length,
        sent: sentMessages.length,
      },
      profiles: {
        bookmarked: bookmarks.length,
        viewed: viewed.length,
        visitors: visitors.length,
        blocked: blockedProfiles.length,
        shortlisted: shortlisted.length,
      },
      contacts: {
        viewed: viewedContacts.length,
        viewedMy: viewedMyContacts.length,
      },
    };
  }
}

module.exports = new StatsService();
