import requests, json, os

def sprint(string, *args, **kwargs):
    try:
        print(string, *args, **kwargs)
    except UnicodeEncodeError:
        string = string.encode('utf-8', errors=ignore)\
            .decode('ascii', errors=ignore)
        print(string, **args, **kwargs)

def print_title(title):
    sprint("\n")
    sprint("=={}==".format('=' * len(title)))
    sprint("= {} =".format(title))
    sprint("=={}==".format('=' * len(title)))

def main(loc, apiKey):
    params = (
        ('q', loc),
        ('units', 'metric'),
        ('appid', apiKey),
    )
    responses = requests.get("http://api.openweathermap.org/data/2.5/weather", params=params)
    dat = json.loads(responses.text)
    name = dat["name"]
    lon = dat["coord"]["lon"]
    lat = dat["coord"]["lat"]
    country = dat["sys"]["country"]
    weather = dat["weather"][0]["main"]
    desc = dat["weather"][0]["description"]
    tempinc = int(dat["main"]["temp"])
    tempcolour = "97"
    windkph = int(dat["wind"]["speed"])
    windcolour = "92"
    pressure = str(dat["main"]["pressure"])
    cloud = str(dat["clouds"]["all"])
    humidity = str(dat["main"]["humidity"])

    os.system("clear")
    print_title('Live Weather by Azriel')
    print("\033[0;30m\033[46m" + name, end='('); print(lon, end=','); print(lat, end=')'); print("\033[40m\033[0m, " + country)
    print(weather)
    print(desc)
    if tempinc < 0:
        tempcolour = "94"
    elif tempinc >= 0 and tempinc < 10:
        tempcolour = "96"
    elif tempinc >= 10 and tempinc < 20:
        tempcolour = "92"
    elif tempinc >= 20 and tempinc < 30:
        tempcolour = "93"
    else:
        tempcolour = "91"
    temperature = str(dat["main"]["temp"])
    print("\033[0;"+tempcolour+"m"+temperature+"\033[0m °C")
    if windkph >= 0 and windkph < 10:
        windcolour = "92"
    elif windkph >= 10 and windkph < 20:
        windcolour = "93"
    elif windkph >= 20 and windkph <= 30:
        windcolour = "32"
    else:
        windcolour = "91"
    windspd = str(dat["wind"]["speed"])
    print("\033[0;"+windcolour+"m"+windspd+"\033[0m km/h")
    print(pressure+" hPa")
    print("Humidity: "+humidity+"%")
    print("Cloud coverage: "+cloud+"%")

if __name__ == '__main__':
    loc = input("Masukkan Lokasi : ")
    apiKey = "be01b7dc5932a7259399166b3ec16b80"
    main(loc, apiKey)


