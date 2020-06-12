if ("serviceWorker" in navigator) {
	navigator.serviceWorker
		.register("https://" + document.location.hostname + "/serviceworker.js", {
			scope: "https://" + document.location.hostname + "/",
		})
		.then((registration) => {
			console.log("Service worker registered", registration.scope);
		})
		.then(() => {
			subscribeToPush();
			// if ("Notification" in window) {
			// 	console.log("Notifications supported");
			// 	Notification.requestPermission((status) => {
			// 		console.log("Status: ", status);
			// 	});
			// }
		});
}

function subscribeToPush() {
	navigator.serviceWorker.ready.then((registration) => {
		registration.pushManager
			.subscribe({
				userVisibleOnly: true,
			})
			.then((subscription) => {
				console.log(JSON.stringify(subscription));
				console.log("End point: ", subscription.endpoint);
				console.log("User subscribed");
			});
	});
}
