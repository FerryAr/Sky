import cv2
import numpy as np

img = cv2.imread('PATH TO IMAGE')
base_sharp = np.array([[-1, -1, -1], [-1, 9, -1], [-1, -1, -1]])
sharp = cv2.filter2D(img, -1, base_sharp)
gray = cv2.cvtColor(sharp, cv2.COLOR_BGR2GRAY)
invert = cv2.bitwise_not(gray)
gblur = cv2.GaussianBlur(invert,(15,15), sigmaX=0, sigmaY=0)

def dodge(x, y):
    return cv2.divide(x, 255-y,scale=256)

dodge_img = dodge(gray, gblur)

def burn(img, mask):
    return 255 - cv2.divide(255-img, 255-mask, scale=256)

final = burn(dodge_img, gblur)

cv2.imshow('image', final)
cv2.waitKey(0)
cv2.destroyAllWindows()
