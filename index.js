"use strict";
window.onload = () => {
  const CONSTANTS = {
    LOGIN_PAGE: "login.html",
    PORTAL_PAGE: "portal.html",
    LOGGEDINUSER: "loggedInUser",
  };

  if (!sessionStorage.getItem(CONSTANTS.LOGGEDINUSER)) {
    window.location.href = CONSTANTS.LOGIN_PAGE;
  } else {
    window.location.href = CONSTANTS.PORTAL_PAGE;
  }
};
