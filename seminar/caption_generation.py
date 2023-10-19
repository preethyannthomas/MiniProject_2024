import random

# Your code for caption generation
def generate_caption(product_category, clothing_colors):
    # Get the closest textual description from CLIP's knowledge base
    product_category = product_category.lower()

    # Generate captions based on clothing colors
    color_captions = []
    for color in clothing_colors:
        color_captions.append(f"A {color} {product_category}")

    # Generate other random captions
    other_captions = [
        "A stylish " + product_category + " for fashion enthusiasts",
            "An elegant " + product_category + " for your wardrobe",
    "A trendy " + product_category + " for the modern lifestyle",
    "The perfect " + product_category + " to elevate your look",
    "A classic " + product_category + " that never goes out of style",
    "Experience luxury with this " + product_category,
    "Get noticed with this stunning " + product_category,
    "Add a touch of sophistication with this " + product_category,
    "Stay comfortable and stylish in this " + product_category,
    "Upgrade your fashion game with this " + product_category,
    "Perfect for any occasion, this " + product_category,
    "Express yourself with this unique " + product_category,
    "Elevate your fashion quotient with this " + product_category,
    "Step out in confidence with this " + product_category,
    "A must-have " + product_category + " for every wardrobe",
    "Get ready to turn heads with this " + product_category,
    "Stay on-trend with this fashionable " + product_category,
    "Be the center of attention in this " + product_category,
    "Look your best with this versatile " + product_category,
    "Effortlessly chic " + product_category + " for all occasions",
    "Discover the beauty of this " + product_category,
    "A timeless piece for your " + product_category + " collection",
    "Make a statement with this " + product_category,
    "A symbol of elegance and style, this " + product_category,
    "Achieve a stunning look with this " + product_category,
    "Stay cozy and fashionable with this " + product_category,
    "Embrace the latest trends with this " + product_category,
    "Elevate your everyday style with this " + product_category,
    "Experience the ultimate comfort of this " + product_category,
    "Showcase your personality with this " + product_category,
    "Add a pop of color to your outfit with this " + product_category,
    "Unleash your inner fashionista with this " + product_category,
    "The epitome of elegance and class, this " + product_category,
    "A classic choice that never goes out of fashion, this " + product_category,
    "Stay ahead of the fashion curve with this " + product_category,
    "The perfect blend of style and functionality, this " + product_category,
    "Complete your look with this exquisite " + product_category,
    "Elevate your fashion game to new heights with this " + product_category,
    "Discover the true meaning of style with this " + product_category,
    "Perfectly designed for the modern " + product_category + " lover",
    "A true masterpiece that defines " + product_category + " perfection",
    "Express your unique style with this " + product_category,
    "The ultimate " + product_category + " for fashion-forward individuals",
    "Enhance your beauty with this " + product_category,
    "Create a lasting impression with this " + product_category,
    "Step into the world of elegance with this " + product_category,
    "Embrace sophistication with this " + product_category,
    "Upgrade your wardrobe with this exceptional " + product_category,
    ]

    # Combine color-based and random captions
    captions = color_captions + other_captions

    # Return a random caption from the list
    return random.choice(captions)
def classify_gender(predicted_category):
    women_categories = ["saree", "kurti", "churidhar", "skirt"]
    men_categories = ["shirt", "jeans"]

    predicted_category = predicted_category.lower()

    if predicted_category in women_categories:
        return "Women"
    elif predicted_category in men_categories:
        return "Men"
    else:
        return "unknown"