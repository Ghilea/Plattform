Set WinScriptHost = CreateObject("WScript.Shell")
WinScriptHost.Run Chr(34) & "C:\wamp64\www\modules\events\addEvents.bat" & Chr(34), 0
Set WinScriptHost = Nothing