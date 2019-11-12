package com.example.sendnotification;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;

public class PageNotFoundActivity extends AppCompatActivity {

    Button btn_try_again;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_page_not_found);

        btn_try_again=(Button)findViewById(R.id.btn_try_again);
        final SharedPreferences pref = getApplicationContext().getSharedPreferences("MyPref", 0); // 0 - for private mode
        final SharedPreferences.Editor editor = pref.edit();

        btn_try_again.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                NetworkInfo info = (NetworkInfo) ((ConnectivityManager)
                        getApplicationContext().getSystemService(Context.CONNECTIVITY_SERVICE)).getActiveNetworkInfo();
                if (info == null)
                {
                    Intent i=new Intent(getApplicationContext(),PageNotFoundActivity.class);
                    startActivity(i);
                }else {
                    Intent i=new Intent(getApplicationContext(),CallUrlActivity.class);
                    i.putExtra("mobile_no",pref.getString("Username",""));
                    i.putExtra("password",pref.getString("Password",""));
                    startActivity(i);
                }
            }
        });

    }
}
