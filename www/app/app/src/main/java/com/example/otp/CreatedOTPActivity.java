package com.example.otp;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import android.app.Activity;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

public class CreatedOTPActivity extends AppCompatActivity {

    private BackPressCloseHandler backKeyClickHandler;
    private TextView getCustomerOTP;



    @Override
    public void onBackPressed() {
        // super.onBackPressed();
       // backKeyClickHandler.onBackPressed();
       AlertDialog.Builder builder = new AlertDialog.Builder(CreatedOTPActivity.this);
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
        alert.show();
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_created_otp);
       // backKeyClickHandler = new BackPressCloseHandler(this);




        getCustomerOTP = findViewById(R.id.userOTP);

        Button exitButton = (Button) findViewById(R.id.Exit);
        Button recreateButton = (Button) findViewById(R.id.Recreate);
        // ImageButton backButton = (ImageButton) findViewById(R.id.Back);



        Intent intent = getIntent();
         String userID = intent.getStringExtra("userID");
         String userPassword = intent.getStringExtra("userPassword");
         String userUUID = intent.getStringExtra("userUUID");
         String userCP = intent.getStringExtra("userCP");
         String userRN = intent.getStringExtra("userRN");

        final Intent intent2 = new Intent(CreatedOTPActivity.this, CreateOTPActivity.class);

        intent2.putExtra( "userID", userID);
        intent2.putExtra( "userPassword", userPassword);
        intent2.putExtra( "userUUID", userUUID );
        intent2.putExtra( "userCP", userCP);


        Response.Listener<String> responseListener = new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try {
                    JSONObject jsonObject = new JSONObject(response);
                    String success = jsonObject.getString("success");


                    if (success.equals("OK")) {

                        String userCode = jsonObject.getString("userCode");
                        //Toast.makeText( getApplicationContext(), success, Toast.LENGTH_SHORT ).show();
                        getCustomerOTP.setText(userCode);

                    }




                    else {
                        Toast.makeText( getApplicationContext(), "OTP 생성 실패", Toast.LENGTH_SHORT ).show();
                        Toast.makeText( getApplicationContext(), success, Toast.LENGTH_SHORT ).show();
                        return;
                    }

                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        };
        OTPRequest newOTPRequest = new OTPRequest(userID, userPassword, userUUID, userRN, responseListener );
        RequestQueue queue = Volley.newRequestQueue( CreatedOTPActivity.this );
        queue.add( newOTPRequest );





        exitButton.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v){
                AlertDialog.Builder builder = new AlertDialog.Builder(CreatedOTPActivity.this);
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
                alert.show();
            }
        });

        recreateButton.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v){
                AlertDialog.Builder builder = new AlertDialog.Builder(CreatedOTPActivity.this);
                builder.setMessage("OTP를 재생성 하시겠습니까?");
                builder.setTitle("")
                        .setCancelable(false)
                        .setPositiveButton("네", new DialogInterface.OnClickListener() {

                            public void onClick(DialogInterface dialog, int i) {
                                startActivity(intent2);
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
                alert.show();
            }
        });


       /* backButton.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View view) {
                Intent intent = new Intent(getApplicationContext(), SendEmailRandomNumberActivity.class);
                startActivity(intent);
                finish();
            }
        }); */


    }
}
