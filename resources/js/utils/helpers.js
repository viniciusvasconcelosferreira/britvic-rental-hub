export function transformData(data) {
    const key = data["id"];
    const value = `${data['brand']} - ${data['model']} - ${data['number_plate']}`;
    return {[key]: value};
}
