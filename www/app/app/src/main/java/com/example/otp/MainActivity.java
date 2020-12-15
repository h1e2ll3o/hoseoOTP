package com.example.otp;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;

public class MainActivity extends AppCompatActivity {

    private BackPressCloseHandler backKeyClickHandler;

    @Override
    public void onBackPressed() {
        // super.onBackPressed();
        backKeyClickHandler.onBackPressed();
        /* AlertDialog.Builder builder = new AlertDialog.Builder(MainActivity.this);
        builder.setMessage("정말로 종료하시겠습니까?");
        builder.setTitle("")
                .setCancelable(false)
                .setPositiveButton("네", new DialogInterface.OnClickListener() {

                    public void onClick(DialogInterface dialog, int i) {
                        finish();
                    }
                })
                .setNegativeButton("아니요", new DialogInterface.OnClickListener() {

                    public void onClick(DialogInterface dialog, int i) {
                        dialog.cancel();
                    }
                });
        AlertDialog alert = builder.create();
        alert.setTitle("");
        alert.show(); */
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        backKeyClickHandler = new BackPressCloseHandler(this);

        Handler handler = new Handler() {
            public void handleMessage(Message msg) {
                super.handleMessage(msg);

                startActivity(new Intent(MainActivity.this, LoginActivity.class));

                MainActivity.this.finish();
            }
        };
        handler.sendEmptyMessageDelayed(0, 2000);
    }
}
