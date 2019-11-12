package com.example.sendnotification.services;

import android.content.Intent;
import android.content.SharedPreferences;
import android.util.Log;
import android.widget.Toast;

import com.example.sendnotification.CallUrlActivity;
import com.example.sendnotification.MainActivity;
import com.example.sendnotification.NotificationVO;
import com.example.sendnotification.utils.NotificationUtils;
import com.google.firebase.messaging.FirebaseMessagingService;
import com.google.firebase.messaging.RemoteMessage;

import java.util.Map;

public class MyFirebaseMessagingService extends FirebaseMessagingService {
    private static final String TAG = "MyFirebaseMsgingService";
    private static final String TITLE = "title";
    private static final String EMPTY = "";
    private static final String MESSAGE = "message";
    private static final String IMAGE = "image";
    private static final String ACTION = "action";
    private static final String DATA = "data";
    private static final String ACTION_DESTINATION = "action_destination";

    @Override
    public void onMessageReceived(RemoteMessage remoteMessage) {

        Log.d(TAG, "From: " + remoteMessage.getFrom());

        // Check if message contains a data payload.
        if (remoteMessage.getData().size() > 0) {
            Log.d(TAG, "Message data payload: " + remoteMessage.getData());
            Map<String, String> data = remoteMessage.getData();
            handleData(data);

        } else if (remoteMessage.getNotification() != null) {
            Log.d(TAG, "Message Notification Body: " + remoteMessage.getNotification().getBody());
            handleNotification(remoteMessage.getNotification());
        }// Check if message contains a notification payload.

    }

    private void handleNotification(RemoteMessage.Notification RemoteMsgNotification) {

        final SharedPreferences pref = getApplicationContext().getSharedPreferences("MyPref", 0); // 0 - for private mode
        final SharedPreferences.Editor editor = pref.edit();
        String message = RemoteMsgNotification.getBody();
        String title = RemoteMsgNotification.getTitle();
        NotificationVO notificationVO = new NotificationVO();
        notificationVO.setTitle(title);
        notificationVO.setMessage(message);

        Intent resultIntent = new Intent(getApplicationContext(), CallUrlActivity.class);
        resultIntent.putExtra("mobile_no",pref.getString("Username",""));
        resultIntent.putExtra("password",pref.getString("Password",""));
        NotificationUtils notificationUtils = new NotificationUtils(getApplicationContext());
        notificationUtils.displayNotification(notificationVO, resultIntent);
        notificationUtils.playNotificationSound();
    }

    private void handleData(Map<String, String> data) {
        String title = data.get(TITLE);
        String message = data.get(MESSAGE);
        String iconUrl = data.get(IMAGE);
        String action = data.get(ACTION);
        String actionDestination = data.get(ACTION_DESTINATION);
        NotificationVO notificationVO = new NotificationVO();
        notificationVO.setTitle(title);
        notificationVO.setMessage(message);
        notificationVO.setIconUrl(iconUrl);
        notificationVO.setAction(action);
        notificationVO.setActionDestination(actionDestination);
        final SharedPreferences pref = getApplicationContext().getSharedPreferences("MyPref", 0); // 0 - for private mode
        final SharedPreferences.Editor editor = pref.edit();

        Intent resultIntent = new Intent(getApplicationContext(), CallUrlActivity.class);
        resultIntent.putExtra("mobile_no",pref.getString("Username",""));
        resultIntent.putExtra("password",pref.getString("Password",""));
        NotificationUtils notificationUtils = new NotificationUtils(getApplicationContext());
        notificationUtils.displayNotification(notificationVO, resultIntent);
        notificationUtils.playNotificationSound();
    }
}