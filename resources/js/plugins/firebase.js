import * as firebase from "firebase";

const configOptions = {
  apiKey: "AIzaSyCQe-1BMKx5MWxqILTkL6e9AzFFzXj42_0",
  authDomain: "ydsf-cf-d776e.firebaseapp.com",
  databaseURL: "https://ydsf-cf-d776e.firebaseio.com",
  projectId: "ydsf-cf-d776e",
  storageBucket: "ydsf-cf-d776e.appspot.com",
  messagingSenderId: "29824586956",
  appId: "1:29824586956:web:198e3ebf0d3728a57b9e69",
  measurementId: "G-Z0RDJT5GQD",
};

firebase.initializeApp(configOptions);

firebase.auth().useDeviceLanguage();

export default firebase;
