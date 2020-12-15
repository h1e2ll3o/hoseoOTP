package com.example.otp;

import androidx.annotation.NonNull;
import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;

import android.Manifest;
import android.app.Activity;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.media.MediaDrm;
import android.net.Uri;
import android.nfc.Tag;
import android.os.Build;
import android.os.Bundle;
import android.os.StrictMode;
import android.provider.Settings;
import android.telephony.TelephonyManager;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;
import java.util.UUID;

import static android.os.Build.VERSION_CODES.M;

public class LoginActivity<permissionCheck> extends AppCompatActivity {

    private static final int MY_PERMISSION_STORAGE = 1111;
    private static final String TODO = null;
    private BackPressCloseHandler backKeyClickHandler;

    private EditText ID;
    private EditText Password;
    private Button Login;
    private CheckBox AutoLogin;
    private Context mContext; // 자동 로그인
    private String deviceID;
    private TextView getCustomerCP;
    private Integer UUIDCheckNB = 0;
    private String getUUID;
    public SharedPreferences prefs;
    public SharedPreferences prefsU;






/*
    private void checkPermission(){
        if (ContextCompat.checkSelfPermission(this, Manifest.permission.READ_PHONE_STATE) != PackageManager.PERMISSION_GRANTED) {
            // 다시 보지 않기 버튼을 만드려면 이 부분에 바로 요청을 하도록 하면 됨 (아래 else{..} 부분 제거)
            // ActivityCompat.requestPermissions((Activity)mContext, new String[]{Manifest.permission.CAMERA, Manifest.permission.READ_EXTERNAL_STORAGE, Manifest.permission.WRITE_EXTERNAL_STORAGE}, MY_PERMISSION_CAMERA);

            // 처음 호출시엔 if()안의 부분은 false로 리턴 됨 -> else{..}의 요청으로 넘어감
            if (ActivityCompat.shouldShowRequestPermissionRationale(this, Manifest.permission.READ_PHONE_STATE)) {
                new AlertDialog.Builder(this)
                        .setTitle("알림")
                        .setMessage("저장소 권한이 거부되었습니다. 사용을 원하시면 설정에서 해당 권한을 직접 허용하셔야 합니다.")
                        .setNeutralButton("설정", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialogInterface, int i) {
                                Intent intent = new Intent(Settings.ACTION_APPLICATION_DETAILS_SETTINGS);
                                intent.setData(Uri.parse("package:" + getPackageName()));
                                startActivity(intent);
                            }
                        })
                        .setPositiveButton("확인", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialogInterface, int i) {
                                finish();
                            }
                        })
                        .setCancelable(false)
                        .create()
                        .show();


            } else {
                ActivityCompat.requestPermissions(this, new String[]{Manifest.permission.WRITE_EXTERNAL_STORAGE, Manifest.permission.READ_EXTERNAL_STORAGE, Manifest.permission.READ_PHONE_STATE}, MY_PERMISSION_STORAGE);
            }
        }
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        switch (requestCode) {
            case MY_PERMISSION_STORAGE:
                for (int i = 0; i < grantResults.length; i++) {
                    // grantResults[] : 허용된 권한은 0, 거부한 권한은 -1
                    if (grantResults[i] < 0) {
                        Toast.makeText(this, "해당 권한을 활성화 하셔야 합니다.", Toast.LENGTH_SHORT).show();
                        return;
                    }
                }
                // 허용했다면 이 부분에서..

                break;
        }
    }
 */



    /*
    private String GetDevicesUUID(Context mContext) {
        final TelephonyManager tm = (TelephonyManager) mContext.getSystemService(Context.TELEPHONY_SERVICE);
        final String tmDevice, tmSerial, androidId;
        tmDevice = "" + tm.getDeviceId();
        tmSerial = "" + tm.getSimSerialNumber();
        androidId = "" + android.provider.Settings.Secure.getString(getContentResolver(), android.provider.Settings.Secure.ANDROID_ID);
        UUID deviceUuid = new UUID(androidId.hashCode(), ((long)tmDevice.hashCode() << 32) | tmSerial.hashCode());
        String deviceId = deviceUuid.toString();
        Log.d("UUID 확인", "userUUID >>> "+ deviceId);
        return deviceId;
    }

     */

/*
    public void checkFirstRun(){
        boolean isFirstRun = prefs.getBoolean("isFirstRun",true);
        if(isFirstRun)
        {
            getUUID = UUID.randomUUID().toString();
            SharedPreferences.Editor editor = prefsU.edit();
            editor.putString("UUID", getUUID);
            editor.commit();
            prefs.edit().putBoolean("isFirstRun",false).apply();
        }
    }
*/


    @Override
    public void onBackPressed() {
        // super.onBackPressed();
        backKeyClickHandler.onBackPressed();
        /* AlertDialog.Builder builder = new AlertDialog.Builder(LoginActivity.this);
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
        setContentView(R.layout.activity_login);
        backKeyClickHandler = new BackPressCloseHandler(this);

        ID = findViewById(R.id.ID);
        Password = findViewById(R.id.Password);

       // checkPermission();


        //prefsU = getSharedPreferences("PrefsU", MODE_PRIVATE);
       // prefs = getSharedPreferences("Pref", MODE_PRIVATE);


       //checkFirstRun();

       //final String prefData = prefsU.getString("UUID", "");


         TelephonyManager tm = (TelephonyManager) getSystemService(Context.TELEPHONY_SERVICE);
         final String uID = Settings.Secure.getString(getApplicationContext().getContentResolver(), Settings.Secure.ANDROID_ID);



        int permissionCheck = ContextCompat.checkSelfPermission(this, Manifest.permission.SEND_SMS);
        if (permissionCheck == PackageManager.PERMISSION_GRANTED) {
            //Toast.makeText(this, "SMS 수신 권한 있음.", Toast.LENGTH_LONG).show();
        } else {
            Toast.makeText(this, "SMS 수신 권한 없음.", Toast.LENGTH_LONG).show();
            if (ActivityCompat.shouldShowRequestPermissionRationale(this, Manifest.permission.SEND_SMS)) {
                Toast.makeText(this, "SMS 권한 설명 필요함.", Toast.LENGTH_LONG).show();
            } else {
                ActivityCompat.requestPermissions(this, new String[]{Manifest.permission.SEND_SMS}, 1);
            }
        }


  /*
        AutoLogin = findViewById(R.id.AutoLogin);

        // 자동 로그인 시작
        mContext = this;
        AutoLogin = findViewById(R.id.AutoLogin);

        boolean boo = PreferenceManager.getBoolean(mContext, "AutoLogin");
        if (boo) {
            ID.setText(PreferenceManager.getString(mContext, "ID"));
            Password.setText(PreferenceManager.getString(mContext, "Password"));
            AutoLogin.setChecked(true);
        }


        AutoLogin.setOnClickListener(new CheckBox.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (((CheckBox) v).isChecked()) {
                    PreferenceManager.setString(mContext, "ID", ID.getText().toString());
                    PreferenceManager.setString(mContext, "Password", Password.getText().toString());
                    PreferenceManager.setBoolean(mContext, "AutoLogin", AutoLogin.isChecked());
                    Toast.makeText(getApplicationContext(), "다른 사용자가 사용하지 못하게 해주세요.", Toast.LENGTH_SHORT).show();

                } else {
                    PreferenceManager.setBoolean(mContext, "AutoLogin", AutoLogin.isChecked());
                    PreferenceManager.clear(mContext);
                }
            }
        }); // 자동 로그인 끝



         */

/*
        final TelephonyManager tm = (TelephonyManager) getBaseContext().getSystemService(Context.TELEPHONY_SERVICE);

        final String tmDevice, tmSerial, androidId;
        tmDevice = "" + tm.getDeviceId();
        tmSerial = "" + tm.getSimSerialNumber();
        androidId = "" + android.provider.Settings.Secure.getString(getContentResolver(), android.provider.Settings.Secure.ANDROID_ID);

        UUID deviceUuid = new UUID(androidId.hashCode(), ((long)tmDevice.hashCode() << 32) | tmSerial.hashCode());
        String deviceId = deviceUuid.toString();
        Toast.makeText(getApplicationContext(), deviceId, Toast.LENGTH_SHORT).show();




 */











        Login = findViewById(R.id.Login);


        Login.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View view) {


                String userID = ID.getText().toString();
                String userPass = Password.getText().toString();
                // String userUUID = prefData;
                 //Toast.makeText( getApplicationContext(), userUUID, Toast.LENGTH_SHORT ).show();

                String userUUID = uID;
               // Toast.makeText( getApplicationContext(), userUUID, Toast.LENGTH_SHORT ).show();
                String userUUIDCheckNB = Integer.toString(UUIDCheckNB);
               // Toast.makeText( getApplicationContext(), userUUIDCheckNB, Toast.LENGTH_SHORT ).show();





                if(userID.getBytes().length <= 0) {
                    Toast.makeText(LoginActivity.this, "아이디를 입력하세요.", Toast.LENGTH_SHORT).show();
                } else if(userPass.getBytes().length <= 0) {
                    Toast.makeText(LoginActivity.this, "비밀번호를 입력하세요.", Toast.LENGTH_SHORT).show();
                } else {



                    Response.Listener<String> responseListener = new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {
                            try {
                                JSONObject jsonObject = new JSONObject(response);
                                String success = jsonObject.getString("success");

                                if (success.equals("UUIDnull")) {

                                    String userName = jsonObject.getString( "userName" );
                                    String userCP = jsonObject.getString( "userCP" );

                                    AlertDialog.Builder builder = new AlertDialog.Builder(LoginActivity.this);
                                    builder.setTitle(userName + "님 휴대폰이 맞습니까?").setMessage("\n" + userCP + "\n\n해당 휴대폰으로만 로그인이 가능합니다.")
                                            .setPositiveButton("네", new DialogInterface.OnClickListener() {
                                                public void onClick(DialogInterface dialog, int i) {
                                                    dialog.cancel();
                                                    UUIDCheckNB++;
                                                    Toast.makeText(getApplicationContext(), "로그인을 다시 해주세요.", Toast.LENGTH_SHORT).show();
                                                }
                                            })
                                            .setNegativeButton("아니요", new DialogInterface.OnClickListener() {

                                                public void onClick(DialogInterface dialog, int i) {
                                                    dialog.cancel();
                                                }
                                            });
                                    AlertDialog alert = builder.create();
                                    alert.show();


                                } else if (success.equals("UUIDfalse")) {

                                    String userName = jsonObject.getString( "userName" );

                                    AlertDialog.Builder builder = new AlertDialog.Builder(LoginActivity.this);
                                    builder.setTitle(userName + "님 로그인 불가").setMessage("\n" + "은행 홈페이지 > 로그인 > 마이페이지 > 개인정보수정 > 휴대폰정보 > 삭제 \n해주세요.")
                                            .setPositiveButton("확인", new DialogInterface.OnClickListener() {

                                                public void onClick(DialogInterface dialog, int i) {
                                                    dialog.cancel();
                                                }
                                            });
                                    AlertDialog alert = builder.create();
                                    alert.show();

                                } else if (success.equals("true")) {

                                    String userID = jsonObject.getString( "userID" );
                                    String userPass = jsonObject.getString( "userPassword" );
                                    String userName = jsonObject.getString( "userName" );
                                    String userAge = jsonObject.getString( "userAge" );
                                    String userUUID = jsonObject.getString( "userUUID" );
                                    String userCP = jsonObject.getString( "userCP" );
                                    //String userRN = jsonObject.getString("userRN");



                                        //Toast.makeText( getApplicationContext(), "로그인 성공", Toast.LENGTH_SHORT ).show();
                                        Intent intent = new Intent( LoginActivity.this, LoginOkActivity.class );

                                        intent.putExtra( "userID", userID );
                                        intent.putExtra( "userPassword", userPass );
                                        intent.putExtra( "userName", userName );
                                        intent.putExtra( "userAge", userAge );
                                        intent.putExtra( "userUUID", userUUID );
                                        intent.putExtra( "userCP", userCP);
                                        //intent.putExtra( "userRN", userRN);

                                        startActivity( intent );
                                        LoginActivity.this.finish();
                                    }




                               else {
                                    Toast.makeText( getApplicationContext(), "로그인 실패", Toast.LENGTH_SHORT ).show();
                                    //Toast.makeText( getApplicationContext(), success, Toast.LENGTH_SHORT ).show();
                                    return;
                                }

                            } catch (JSONException e) {
                                e.printStackTrace();
                            }
                        }
                    };
                    LoginRequest loginRequest = new LoginRequest( userID, userPass, userUUID, userUUIDCheckNB, responseListener );
                    RequestQueue queue = Volley.newRequestQueue( LoginActivity.this );
                    queue.add( loginRequest );








                    // Intent intent = new Intent(getApplicationContext(), LoginOkActivity.class);
                    // startActivity(intent);
                    // finish();

                }


            }
        });






    }



}
