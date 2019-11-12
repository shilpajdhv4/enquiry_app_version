package com.example.sendnotification;

import androidx.appcompat.app.AppCompatActivity;

import android.app.NotificationChannel;
import android.app.NotificationManager;
import android.content.Context;
import android.graphics.Color;
import android.os.Bundle;
import android.os.StrictMode;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.firebase.iid.FirebaseInstanceId;
import com.google.firebase.messaging.FirebaseMessaging;
import com.google.firebase.messaging.RemoteMessage;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLConnection;
import java.util.Random;

public class MainActivity extends AppCompatActivity implements IRequestListener{

    private static final String TAG = "MainActivity";
    private TextView deviceText;
    private TokenService tokenService;
    private Button buttonUpstreamEcho;

    String JsonUrl = "http://103.71.64.153:85/PHP/fcmtest/push_notification.php";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        StrictMode.setThreadPolicy(new StrictMode.ThreadPolicy.Builder().permitNetwork().build());
        Log.d(TAG, "FCM Token creation logic");
        buttonUpstreamEcho = (Button) findViewById(R.id.buttonUpstreamEcho);

        // Get variables reference
        deviceText = (TextView) findViewById(R.id.deviceText);

        try {
            //Get token from Firebase
            FirebaseMessaging.getInstance().subscribeToTopic("test");
            final String token = FirebaseInstanceId.getInstance().getToken();
            Log.d(TAG, "Token: " + token);
            deviceText.setText(token);

            //Call the token service to save the token in the database
            tokenService = new TokenService(this, this);
            tokenService.registerTokenInDB(token);
        }catch (Exception e){
            e.printStackTrace();
            Toast.makeText(getApplicationContext(),"Error="+e,Toast.LENGTH_LONG).show();
        }


        buttonUpstreamEcho.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Log.d(TAG, "Echo Upstream message logic");

                URL url = null;
                try {
                    url = new URL(JsonUrl);
                    URLConnection request = url.openConnection();
                    request.connect();

                    //creating a string request to send request to the url
                    StringRequest stringRequest = new StringRequest(Request.Method.GET, JsonUrl,
                            new Response.Listener<String>() {
                                @Override
                                public void onResponse(String response) {
                                    //hiding the progressbar after completion

                                    try {
                                        //getting the whole json object from the response
                                        JSONObject obj = new JSONObject(response);
                                        Toast.makeText(getApplicationContext(),"Response="+obj,Toast.LENGTH_LONG).show();

                                    } catch (JSONException e) {
                                        e.printStackTrace();
                                    }
                                }
                            },
                            new Response.ErrorListener() {
                                @Override
                                public void onErrorResponse(VolleyError error) {
                                    //displaying the error in toast if occur
                                    Toast.makeText(getApplicationContext(), error.getMessage(), Toast.LENGTH_SHORT).show();
                                }
                            });

                    //creating a request queue
                    RequestQueue requestQueue = Volley.newRequestQueue(getApplicationContext());

                    //adding the string request to request queue
                    requestQueue.add(stringRequest);


                } catch (MalformedURLException e) {
                    e.printStackTrace();
                    Toast.makeText(getApplicationContext(),"Error="+e,Toast.LENGTH_LONG).show();
                } catch (IOException e) {
                    e.printStackTrace();
                    Toast.makeText(getApplicationContext(),"Error="+e,Toast.LENGTH_LONG).show();
                }
            }
        });

    }

    @Override
    public void onComplete() {
        Log.d(TAG, "Token registered successfully in the DB");
    }

    @Override
    public void onError(String message) {
        Log.d(TAG, "Error trying to register the token in the DB: " + message);
    }
}
