
importScripts('https://www.gstatic.com/firebasejs/8.2.9/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.2.9/firebase-messaging.js');
// Initialize Firebase
var firebaseConfig = {
	apiKey: "AIzaSyAMR7iRFrlldV7KyBK_QFtpwfnzg_poM0E",
	authDomain: "laratest-9f9f6.firebaseapp.com",
	projectId: "laratest-9f9f6",
	storageBucket: "laratest-9f9f6.appspot.com",
	messagingSenderId: "1522258239",
	appId: "1:1522258239:web:51c3fa84aebb3ca516838a",
	measurementId: "G-5RYRQ8ZNB4"
};
firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();