package com.example.sendnotification;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.os.Handler;
import android.util.Log;
import android.view.Window;
import android.view.WindowManager;
import android.widget.Toast;

import com.google.firebase.iid.FirebaseInstanceId;
import com.google.firebase.messaging.FirebaseMessaging;

public class SplashActivity extends AppCompatActivity implements IRequestListener{

    private static int SPLASH_TIME_OUT = 2000;
    private TokenService tokenService;
    private static final String TAG = "SplashActivity";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        requestWindowFeature(Window.FEATURE_NO_TITLE);
        getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
                WindowManager.LayoutParams.FLAG_FULLSCREEN);
        setContentView(R.layout.activity_splash);

        final SharedPreferences pref = getApplicationContext().getSharedPreferences("MyPref", 0); // 0 - for private mode
        final SharedPreferences.Editor editor = pref.edit();

        try {
            //Get token from Firebase
            FirebaseMessaging.getInstance().subscribeToTopic("test");
            final String token = FirebaseInstanceId.getInstance().getToken();
            Log.d(TAG, "Token: " + token);

            //Call the token service to save the token in the database
            tokenService = new TokenService(this, this);
            tokenService.registerTokenInDB(token);

        }catch (Exception e){
            e.printStackTrace();
            Toast.makeText(getApplicationContext(),"Error="+e,Toast.LENGTH_LONG).show();
        }

        new Handler().postDelayed(new Runnable() {

            @Override
            public void run() {
                if(!pref.getString("Username","").equals("") && !pref.getString("Password","").equals("")){
                    Intent i=new Intent(SplashActivity.this,CallUrlActivity.class);
                    i.putExtra("mobile_no",pref.getString("Username",""));
                    i.putExtra("password",pref.getString("Password",""));
                    startActivity(i);
                    finish();
                }else {
                    Intent i=new Intent(SplashActivity.this,LoginActivity.class);
                    startActivity(i);
                    finish();
                }
            }
        }, SPLASH_TIME_OUT);
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
