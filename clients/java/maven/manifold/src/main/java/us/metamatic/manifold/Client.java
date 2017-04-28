package us.metamatic.manifold;

import java.io.File;
import java.io.IOException;

/**
 * Manifold API usage example client
 *
 */
public class Client {

	private static final String URL_MANIFOLD = "http://manifold.metamatic.us/v1/compute/";
	private static final String CHARSET = "utf-8";

	public String doPost(String apiKey, String filePath) {
		String taskId = "";
		MultipartUtility multipart;
		try {
			multipart = new MultipartUtility(URL_MANIFOLD, CHARSET);
			multipart.addFormField("api_key", apiKey);
			multipart.addFilePart("datafile", new File(filePath));
			taskId = multipart.finish();
		} catch (IOException e) {
			e.printStackTrace();
		}
		System.out.println(taskId);
		return taskId;
	}

	public String doGet(String taskId) {
		HttpUtility httpUtil = new HttpUtility();
		String response = "";
		while (response.equals("")) {
			try {
				response = httpUtil.sendGet(URL_MANIFOLD + "?task_id=" + taskId);
				Thread.sleep(3000);
			} catch (Exception e) {
				e.printStackTrace();
			}
		}
		System.out.println("Response: [" + response + "]");
		return response;
	}

	public static void main(String[] args) {

		Client client = new Client();
		// First arg is api_key
		String apiKey = args[0];
		// Second arg is 3D file path
		String filePath = args[1];

		String taskId = client.doPost(apiKey, filePath);
		String response = client.doGet(taskId);
		System.out.println(response);

	}
}
