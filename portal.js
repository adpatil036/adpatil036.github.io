"use strict";

var CONSTANTS = {
  FILTER_TYPE: {
    ALL: "All",
  },
  R_ACCOUNTTRANSACTION: "R_ACCOUNTTRANSACTION",
  PASSWORD_MISMATCH: "Password Mismatch",
  LOGGEDINUSER: "loggedInUser",
  BALANCE: "balance",
};

var transactionData = JSON.parse(
  '[{"R_ACCOUNTTRANSACTION":"Sell to Close"},{},{"R_ACCOUNTTRANSACTION":"Cap. Distribution"},{},{"R_ACCOUNTTRANSACTION":"Deposit"},{},{"R_ACCOUNTTRANSACTION":"Check"},{},{},{},{"R_ACCOUNTTRANSACTION":"Sell to Close"},{},{"R_ACCOUNTTRANSACTION":"Buy"},{"R_ACCOUNTTRANSACTION":"Transfer"},{"R_ACCOUNTTRANSACTION":"Interest"},{"R_ACCOUNTTRANSACTION":"Cap. Gains long"},{"R_ACCOUNTTRANSACTION":"Deposit"},{"R_ACCOUNTTRANSACTION":"Buy"},{"R_ACCOUNTTRANSACTION":"Move"},{"R_ACCOUNTTRANSACTION":"Online"},{"R_ACCOUNTTRANSACTION":"Sell"},{"R_ACCOUNTTRANSACTION":"Charge"},{"R_ACCOUNTTRANSACTION":"Interest"},{"R_ACCOUNTTRANSACTION":"Withdrawal"},{"R_ACCOUNTTRANSACTION":"Cap. Gains Short"},{},{"R_ACCOUNTTRANSACTION":"Dividend"},{"R_ACCOUNTTRANSACTION":"Sell"},{},{"R_ACCOUNTTRANSACTION":"Sell to Close"}]'
);

var transactionType;
var selectedFilterType = CONSTANTS.FILTER_TYPE.ALL;
window.onload = () => {
  let url;
  document.getElementById("userName").innerHTML =
    sessionStorage.getItem("loggedInUser");

  document.getElementById("balance").innerHTML = `$ ${localStorage.getItem(
    "balance"
  )}`;

  navigator.geolocation.getCurrentPosition((position) => {
    url =
      "https://us1.locationiq.com/v1/reverse.php?key=pk.6202b2b9b4c51cce665354eed017a565&lat=" +
      position.coords.latitude +
      "&lon=" +
      position.coords.longitude;

    /** Using callback to demostrate its use */
    const callback = (response) => response.text();

    fetch(url)
      .then(callback)
      .then((str) => new window.DOMParser().parseFromString(str, "text/xml"))
      .then((data) => {
        document.getElementById("loginLocation").innerHTML =
          data.getElementsByTagName("result")[0].childNodes[0].nodeValue;
      });
  });

  let uniqueTransactionType = new Set();

  // transactionData = transactionData.filter(
  //   (item) =>
  //     typeof item == "object" &&
  //     item.hasOwnProperty(CONSTANTS.R_ACCOUNTTRANSACTION)
  // );

  transactionData = transactionData.forEach(
    (item) =>
      typeof item == "object" &&
      item.hasOwnProperty(CONSTANTS.R_ACCOUNTTRANSACTION)
  );

  transactionData.map((item) => (item["amount"] = Math.random() * 100000));

  transactionData.forEach((item, index) => {
    /** For deep copy of JS object using stringify and parse */
    const obj = JSON.parse(JSON.stringify(item));

    const date = randomDate(new Date(2020, 0, 1), new Date());
    const id = Math.floor(Math.random() * 1000000);
    transactionData[index] = { id: id, date: date, ...obj };
    uniqueTransactionType.add(item[CONSTANTS.R_ACCOUNTTRANSACTION]);
  });

  transactionType = Array.from(uniqueTransactionType);

  const ele = document.getElementById("filter");
  for (let i = 0; i < Object.values(transactionType).length; i++) {
    ele.innerHTML =
      ele.innerHTML +
      '<option value = "' +
      i +
      '">' +
      String(transactionType[i]) +
      "</option>";
  }
};

/** Update filter type */
const filterData = (ele) => {
  selectedFilterType = ele.value;
};

/** Search the details based on transaction type */
const search = () => {
  let res;
  if (selectedFilterType === CONSTANTS.FILTER_TYPE.ALL) res = transactionData;
  else {
    res = transactionData.filter(
      (item) =>
        item.R_ACCOUNTTRANSACTION === transactionType[selectedFilterType]
    );
  }
  renderTabularData(res);
};
/** Function to generate Random Date */
const randomDate = (start, end = new Date()) =>
  new Date(start.getTime() + Math.random() * (end.getTime() - start.getTime()));

/** Function to render table data */
const renderTabularData = (data) => {
  const ele = document.getElementById("transactionDetails");
  let tableData =
    "<table><tr><th>Transaction Date</th><th>Transaction Type</th><th>Transaction Amount</th</tr>";
  Object.values(data).forEach((item) => {
    const { date, R_ACCOUNTTRANSACTION, amount } = item;
    tableData =
      tableData +
      "<tr><td>" +
      date.toLocaleDateString() +
      "</td><td>" +
      R_ACCOUNTTRANSACTION +
      "</td><td>" +
      amount +
      "</td></tr>";
  });
  tableData += "</td></table>";
  ele.innerHTML = tableData;
};

/** Function to logout */
const logout = () => {
  console.log("User logged off succesfully");
  sessionStorage.removeItem("loggedInUser");
  window.location.href = "login.html";
};
