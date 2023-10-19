import os
from torchvision import datasets
import numpy as np
import cv2
import matplotlib.pyplot as plt
import torch
import torchvision.models as models
import torchvision
from PIL import Image
import torchvision.transforms as transforms
import PIL
from imgaug import augmenters as iaa
import imgaug as ia
import math
import sys
import webcolors
use_cuda = torch.cuda.is_available()
print(use_cuda)
import matplotlib as mpl
mpl.rcParams['axes.grid'] = False
mpl.rcParams['image.interpolation'] = 'nearest'
mpl.rcParams['figure.figsize'] = 15, 25
def show_dataset(dataset, n=15):
    img = np.vstack((np.hstack((np.asarray(dataset[i][0]) for _ in range(n)))for i in range(len(dataset))))
    plt.imshow(img)
    plt.axis('off')
train_dir = 'images/train'
test_dir = 'images/test'
class ImgAugTransform1:

    def __init__(self):
        sometimes = lambda aug: iaa.Sometimes(0.5, aug)

        self.aug = iaa.Sequential(
    [
        # to most images
        iaa.Fliplr(0.5), # horizontal flip
        iaa.Flipud(0.2), # vertical flip

        sometimes(iaa.CropAndPad(
            percent=(-0.05, 0.1),
            pad_mode=ia.ALL,
            pad_cval=(0, 255)
        )),
        sometimes(iaa.Invert(0.05, per_channel=True)), #invert!
        sometimes(iaa.Affine(
            scale={"x": (0.8, 1.2), "y": (0.8, 1.2)},
            translate_percent={"x": (-0.2, 0.2), "y": (-0.2, 0.2)},
            rotate=(-45, 45),
            shear=(-16, 16),
            order=[0, 1],
            cval=(0, 255),
            mode=ia.ALL
        )),
        # execute 0 to 5 of the following (less important) augmenters per image

        iaa.SomeOf((0, 5),
            [
                sometimes(iaa.Superpixels(p_replace=(0, 1.0), n_segments=(20, 200))), # convert images into their superpixel representation
                iaa.OneOf([
                    iaa.GaussianBlur((0, 3.0)),
                    iaa.AverageBlur(k=(2, 7)),
                    iaa.MedianBlur(k=(3, 11)),
                ]),
                iaa.Sharpen(alpha=(0, 1.0), lightness=(0.75, 1.5)),
                iaa.Emboss(alpha=(0, 1.0), strength=(0, 2.0)),

                iaa.SimplexNoiseAlpha(iaa.OneOf([
                    iaa.EdgeDetect(alpha=(0.5, 1.0)),
                    iaa.DirectedEdgeDetect(alpha=(0.5, 1.0), direction=(0.0, 1.0)),
                ])),
                iaa.AdditiveGaussianNoise(loc=0, scale=(0.0, 0.05*255), per_channel=0.5), # add gaussian noise to images
                iaa.OneOf([
                    iaa.Dropout((0.01, 0.1), per_channel=0.5), # randomly remove up to 10% of the pixels
                    iaa.CoarseDropout((0.03, 0.15), size_percent=(0.02, 0.05), per_channel=0.2),
                ]),
                iaa.Invert(0.05, per_channel=True),
                iaa.Add((-10, 10), per_channel=0.5),
                iaa.AddToHueAndSaturation((-20, 20)),

                iaa.OneOf([
                    iaa.Multiply((0.5, 1.5), per_channel=0.5),
                    iaa.FrequencyNoiseAlpha(
                        exponent=(-4, 0),
                        first=iaa.Multiply((0.5, 1.5), per_channel=True),
                        second=iaa.LinearContrast((0.5, 2.0))
                    )
                ]),
                iaa.LinearContrast((0.5, 2.0), per_channel=0.5),
                iaa.Grayscale(alpha=(0.0, 1.0)),
                sometimes(iaa.ElasticTransformation(alpha=(0.5, 3.5), sigma=0.25)),
                sometimes(iaa.PiecewiseAffine(scale=(0.01, 0.05))),
                sometimes(iaa.PerspectiveTransform(scale=(0.01, 0.1)))
            ],
            random_order=True
        )
    ],
    random_order=True
)
    def __call__(self, img):
        img = np.array(img)
        return self.aug.augment_image(img)
import torch
import torchvision
import torchvision.datasets as datasets
import torchvision.transforms as transforms
import PIL
import imgaug as ia
import imgaug.augmenters as iaa
import numpy as np
import matplotlib.pyplot as plt
import random
import cv2

# Define the ImgAug transformation function
class ImgAugTransform1:
    def __init__(self):
        self.aug = iaa.Sequential([
            iaa.Scale((224, 224)),
            iaa.Sometimes(0.5, iaa.HorizontalFlip()),
            iaa.Sometimes(0.5, iaa.Affine(rotate=(-20, 20), mode='symmetric', cval=255, backend='cv2')),
        ])

    def __call__(self, img):
        img = np.array(img)
        return self.aug.augment_image(img)

# Compose transformations for visualization
Xtransform = transforms.Compose([
    ImgAugTransform1(),
    lambda x: PIL.Image.fromarray(x),
    transforms.Resize((224, 224)),
    transforms.ColorJitter(hue=0.05, saturation=0.05),
    transforms.RandomHorizontalFlip(),
    transforms.Lambda(lambda x: x.rotate(random.randint(-20, 20), resample=PIL.Image.BILINEAR)),
])

# Apply transformations to the dataset for visualization
train_data2 = datasets.ImageFolder(train_dir, transform=Xtransform)

# Function to visualize the dataset
def show_dataset(dataset, n=5):
    fig, axes = plt.subplots(n, n, figsize=(10, 10))
    for i in range(n):
        for j in range(n):
            img, _ = dataset[random.randint(0, len(dataset) - 1)]
            axes[i, j].imshow(img)
            axes[i, j].axis('off')
    plt.show()

# Visualize the transformed dataset
show_dataset(train_data2)
Ftransforms = torchvision.transforms.Compose([
    ImgAugTransform1(),
    lambda x: PIL.Image.fromarray(x),
    torchvision.transforms.Resize((224, 224)),
    torchvision.transforms.ColorJitter(hue=.05, saturation=.05),
    torchvision.transforms.RandomHorizontalFlip(),
    torchvision.transforms.RandomRotation(20),  # Remove the 'resample' parameter
    transforms.ToTensor(),
    transforms.Normalize([0.485, 0.456, 0.406], [0.229, 0.224, 0.225])
])
## Applying transformations on the train and test data
train_data = datasets.ImageFolder(train_dir , transform=Ftransforms)
test_data= datasets.ImageFolder(test_dir, transform=Ftransforms)
trainloader = torch.utils.data.DataLoader(train_data, batch_size=128, shuffle=True)
testloader = torch.utils.data.DataLoader(test_data, batch_size=128)
print(train_data.classes)
import torch.nn as nn
import torch.nn.functional as F
loaders_transfer = {
    'train': trainloader,

    'test': testloader
}
# Load the pretrained model from pytorch
res50 = models.resnet50(pretrained=True)
print(res50)
# transfer learning on ResNet
import torchvision.models as models
import torch.nn as nn
model_transfer=res50

for name,child in model_transfer.named_children():
    if name in ['fc']:
        print(name + 'is unfrozen')
        for param in child.parameters():
            param.requires_grad = True
    else:
        print(name + 'is frozen')
        for param in child.parameters():
            param.requires_grad = False

model_transfer.fc = nn.Sequential(
               nn.Linear(2048, 516),
               nn.ReLU(inplace=True),
               nn.Linear(516,64),
               nn.ReLU(inplace=True),
               nn.Linear(64,3))


if use_cuda:
    model_transfer = model_transfer.cuda()
model_transfer  # our model
import torch.optim as optim

criterion_transfer = nn.CrossEntropyLoss()
optimizer_transfer =  optim.SGD(filter(lambda p:p.requires_grad,model_transfer.parameters()), lr=0.002, momentum=0.9)
## need to pass only those param that are unfrrozen!!
def train(n_epochs, loaders, model, optimizer, criterion, use_cuda, save_path):
    """returns trained model"""


    for epoch in range(1, n_epochs+1):
        # initialize variable to monitor training  loss
        train_loss = 0.0


        ###################
        # train the model #
        ###################
        model.train()
        for batch_idx, (data, target) in enumerate(loaders['train']):
            # move to GPU
            if use_cuda:
                data, target = data.cuda(), target.cuda()
            # clear the gradients of all optimized variables
            optimizer.zero_grad()
            ## find the loss and update the model parameters accordingly
            output = model(data)
            loss = criterion(output, target)
            loss.backward()
            optimizer.step()

            train_loss = train_loss + ((1 / (batch_idx + 1)) * (loss.data - train_loss))





        print('Epoch: {} \tTraining Loss: {:.6f}'.format(epoch, train_loss))




        state = {'epoch': epoch + 1, 'state_dict': model.state_dict(),
             'optimizer': optimizer.state_dict(), 'losslogger': criterion, }
        torch.save(state,save_path)



    return model



# train the model
n_epochs=100
model_transfer = train(n_epochs, loaders_transfer, model_transfer, optimizer_transfer, criterion_transfer, use_cuda, 'model_transfer.pt')

checkpoint = torch.load('model_transfer.pt')
model_transfer.load_state_dict(checkpoint['state_dict'])
optimizer_transfer.load_state_dict(checkpoint['optimizer'])
n_epochs = checkpoint['epoch']
criterion_transfer = checkpoint['losslogger']
# train the model
n_epochs=50
model_transfer = train(n_epochs, loaders_transfer, model_transfer, optimizer_transfer, criterion_transfer, use_cuda, 'model_transfer.pt')

def test(loaders, model, criterion, use_cuda):

    # monitor test loss and accuracy
    test_loss = 0.
    correct = 0.
    total = 0.

    model.eval()
    for batch_idx, (data, target) in enumerate(loaders['test']):
        # move to GPU
        if use_cuda:
            data, target = data.cuda(), target.cuda()
        # forward pass: compute predicted outputs by passing inputs to the model
        output = model(data)
        # calculate the loss
        loss = criterion(output, target)
        # update average test loss
        test_loss = test_loss + ((1 / (batch_idx + 1)) * (loss.data - test_loss))
        # convert output probabilities to predicted class
        pred = output.data.max(1, keepdim=True)[1]
        # compare predictions to true label
        correct += np.sum(np.squeeze(pred.eq(target.data.view_as(pred))).cpu().numpy())
        total += data.size(0)

    print('Test Loss: {:.6f}\n'.format(test_loss))

    print('\nTest Accuracy: %2d%% (%2d/%2d)' % (
        100. * correct / total, correct, total))
test(loaders_transfer, model_transfer, criterion_transfer, use_cuda)
class_names= train_data.classes
print(len(class_names))
print("0",class_names[0])
print("1",class_names[1])
print("2",class_names[2])
def predict_product(img_path):

    transform = transforms.Compose([transforms.Resize(256),
                                      transforms.CenterCrop(224),
                                      transforms.ToTensor(),
                                      transforms.Normalize([0.485, 0.456, 0.406],[0.229, 0.224, 0.225])])
    file = img_path
    file = Image.open(file).convert('RGB')
    img = transform(file).unsqueeze(0)
    device = torch.device("cuda" if torch.cuda.is_available() else "cpu")

    model_transfer.eval()

    with torch.no_grad():

        out = model_transfer(img.to(device))
        ps = torch.exp(out)
        top_p, top_class = ps.topk(1, dim=1)
        index = top_class.item()
    return class_names[index]