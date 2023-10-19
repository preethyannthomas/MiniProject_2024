from flask import Flask, jsonify
from image_processing import cloth_color
from caption_generation import generate_caption, classify_gender

app = Flask(__name__)

@app.route('/process_image', methods=['POST'])
def process_image_route():
    # Handle image processing and prediction
    image_path = "images/apptest/test4.jpeg"  # Example image path
    product_category = predict_product(image_path)
    gender = classify_gender(product_category)
    clothing_colors = cloth_color(image_path)
    caption = generate_caption(product_category, clothing_colors)

    result = {
        "Product": product_category.capitalize(),
        "Gender": gender,
        "Clothing Colors": clothing_colors,
        "Generated Caption": caption
    }

    return jsonify(result)

if __name__ == '__main__':
    app.run(debug=True)
