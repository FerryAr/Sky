#!/usr/bin/env bash
#|-------------------------------------------------|
#  Live Weather by Azrl using OpenWeatherMap API
#|-------------------------------------------------|

apiKey="be01b7dc5932a7259399166b3ec16b80"
defaultLocation="Wonosobo"
dynamicUpdates=0
degreeCharacter="c"
data=0
lastUpdateTime=0
while [ $# -gt 0 ]
do
option="$1"
    case $option in
      -l) defaultLocation="$2"
            shift
            shift
            ;;
      -d) dynamicUpdates=1
            shift ;;
    -f) degreeCharacter="f"
    		shift ;;
    esac
done
dataPath="wth-$defaultLocation.json"
if [ ! -e $dataPath ];
then
    touch $dataPath
    data=$(curl "http://api.openweathermap.org/data/2.5/weather?q=$defaultLocation&units=metric&appid=$apiKey")
    echo $data > $dataPath
else
    data=$(cat $dataPath)
fi
lastUpdateTime=$(($(busybox date +%s) -600))
while true
do
	lastfileupdate=$(busybox date -r $dataPath +%s)
if [ $(($(busybox date +%s)-$lastfileupdate)) -ge 600 ];
then
	data=$(curl -s "http://api.openweathermap.org/data/2.5/weather?q=$defaultLocation&units=metric&appid=$apiKey")
	echo $data > $dataPath
fi
if [ $(($(busybox date +%s)-$lastUpdateTime)) -ge 600 ];
then
	lastUpdateTime=$(busybox date +%s)
	clear
    echo +------------------------------+
    echo "     Live Weather by Azriel     "
    echo +------------------------------+
	echo -e '\033[0;30m\033[46m'$(echo $data | jq -r .name)'('$(echo $data | jq -r .coord.lon)','$(echo $data | jq -r .coord.lat)')''\033[40m\033[0m', $(echo $data | jq -r .sys.country)
	echo $(echo $data | jq -r .weather[].main)
	echo $(echo $data | jq -r .weather[].description)
	tempinc=$(echo $data | jq -r .main.temp)
	tempcolour=97
	if [ $(echo "$tempinc < 0" | bc) -eq 1 ];
	then
		tempcolour=94
	elif [ $(echo "$tempinc >=0 && $tempinc < 10" | bc) -eq 1 ];
	then
		tempcolour=96
	elif [ $(echo "$tempinc >= 10 && $tempinc < 20" | bc) -eq 1 ];
	then
		tempcolour=92
	elif [ $(echo "$tempinc >=20 && $tempinc < 30" | bc) -eq 1 ];
	then
		tempcolour=93
	else
		tempcolour=91
	fi
	temperature=$tempinc
	if  [ "$degreeCharacter" = "f" ] 
	then
		temperature=$(echo 32+1.8*$tempinc | bc)
	fi
	echo -e '\033[0;'$tempcolour'm'$(echo $temperature)\\033[0m °${degreeCharacter^^}
	wind=$(echo $data | jq .wind.deg)
	winddir=$((2193-(${wind%.*}+45)/90))
	if [ $winddir -eq 2192 ];
	then
		winddir=2190
	elif [ $winddir -eq 2190 ];
	then
		winddir=2192
	else
		:
	fi
	windkph=$(echo $data | jq .wind.speed)
	windcolour=97
	if [ $(echo "$windkph >= 0 && $windkph < 10" | bc) -eq 1 ];
	then
		windcolour=92
	elif  [ $(echo "$windkph >= 10 && $windkph < 20" | bc) -eq 1 ];
	then
		windcolour=93
	elif  [ $(echo "$windkph >= 20 && $windkph <= 30" | bc) -eq 1 ];
	then
		windcolour=32
	else
		windcolour=91
	fi
	echo -e \\u$winddir '\033[0;'$windcolour'm'$windkph\\033[0m km/h
	echo $(echo $data | jq .main.pressure) hPa
	echo Humidity: $(echo $data | jq .main.humidity)%
	echo Cloud coverage: $(echo $data | jq .clouds.all)%
fi
if [ $dynamicUpdates -eq 0 ];
then
  break
fi
done
