package com.example.otp;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.provider.Settings;
import android.telephony.SmsManager;
import android.telephony.TelephonyManager;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.Toast;

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.Random;

public class CreateOTPActivity extends AppCompatActivity {

    private BackPressCloseHandler backKeyClickHandler;

    @Override
    public void onBackPressed() {
        // super.onBackPressed();
        // backKeyClickHandler.onBackPressed();
        AlertDialog.Builder builder = new AlertDialog.Builder(CreateOTPActivity.this);
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
        setContentView(R.layout.activity_create_otp);
        // backKeyClickHandler = new BackPressCloseHandler(this);

        Button b = (Button) findViewById(R.id.CreateOTP);
        b.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View view) {


                Intent intent2 = getIntent();
                String userID = intent2.getStringExtra("userID");
                String userPassword = intent2.getStringExtra("userPassword");
                String userUUID = intent2.getStringExtra("userUUID");
                String userCP = intent2.getStringExtra("userCP");

    /*
                Integer max_num_value = 999999;
                Integer min_num_value = 100000;

                Random random = new Random();

                int RN = random.nextInt(max_num_value - min_num_value + 1) + min_num_value;
                final String userRN = Integer.toString(RN);
                //Toast.makeText(getApplicationContext(), userRN, Toast.LENGTH_SHORT).show();




     */





                Response.Listener<String> responseListener = new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject jsonObject = new JSONObject(response);
                            String success = jsonObject.getString("success");


                           if (success.equals("RN")) {


                               String userID = jsonObject.getString( "userID" );
                               String userPass = jsonObject.getString( "userPassword" );
                               String userCP = jsonObject.getString( "userCP" );
                               String userRN = jsonObject.getString("userRN");



                               // Toast.makeText( getApplicationContext(), success, Toast.LENGTH_SHORT ).show();
                               Intent intent = new Intent( CreateOTPActivity.this, SendSMSRandomNumberActivity.class );

                               intent.putExtra( "userID", userID );
                               intent.putExtra( "userPassword", userPass );
                               intent.putExtra( "userCP", userCP);
                               intent.putExtra( "userRN", userRN);

                                startActivity( intent );
                                CreateOTPActivity.this.finish();

                               try {
                                   //전송
                                   SmsManager smsManager = SmsManager.getDefault();
                                   smsManager.sendTextMessage(userCP, null, userRN, null, null);
                                   //Toast.makeText(getApplicationContext(), "전송 완료!", Toast.LENGTH_SHORT).show();
                               } catch (Exception e) {
                                   Toast.makeText(getApplicationContext(), "SMS 전송실패. 다시 시도해주세요.", Toast.LENGTH_SHORT).show();
                                   e.printStackTrace();
                               }

                           }




                            else {
                                Toast.makeText( getApplicationContext(), "코드 저장 실패", Toast.LENGTH_SHORT ).show();
                               // Toast.makeText( getApplicationContext(), success, Toast.LENGTH_SHORT ).show();
                                return;
                            }

                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                };
                SaveRNRequest saveRNRequest = new SaveRNRequest(userID, userPassword, responseListener );
                RequestQueue queue = Volley.newRequestQueue( CreateOTPActivity.this );
                queue.add( saveRNRequest );




                //startActivity(new Intent(CreateOTPActivity.this, SendSMSRandomNumberActivity.class));
                //finish();

            }
        });
    }
}
