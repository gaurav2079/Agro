using System;

using System.Net.Http;

using System.Text;

using System.Threading.Tasks:

namespace DocumentTranslator
{
class Program
{
static readonly string route = "/batches";

static readonly string endpoint = "<TRANSLATER_SERVICE_ENDPOINT>/translator/text/batch/v1.0";
static readonly string key = "<TRANSLATER_SERVICE_KEY>";

static readonly string json = ("" +

"(\"inputs\": "+

"[{\"source\": "+

"{\"sourceUrl\":\"sp=rl&st=2023-01-09T05:19:09Z&se=2023-01-09T13:19:09Z&spr=https&sv=2021-06-08&sr=c&sig=erPqXPqYH0cfQPV5tuIOxCoCra%2BCPVMjtsYnCyU%2BeNk%3D\"," +

"\"storageSource\": \"AzureBlob\"" +
"},"

"\"targets\": "+

"[{\"targetUrl\":\"<TARGET_SAS_TOKEN>\"," +

"\"storageSource\": \"AzureBlob\"," +

"\"language\": \"fr\"}]}]}");

static async Task Main(string[] args)
{

using HttpClient client = new HttpClient();

using HttpRequestMessage request = new HttpRequestMessage();

{

StringContent data = new StringContent(json, Encoding.UTF8, "application/json");

request.Method = HttpMethod.Post;
request.RequestUri = new Uri(endpoint + route); 
request.Headers.Add("Ocp-Apim-Subscription-Key", key);
request.Content = data;

HttpResponseMessage response = await client.SendAsync(request);

string result = response.Content.ReadAsStringAsync().Result;
if (response.IsSuccessStatusCode)
{
Console.WriteLine($"Operation successful with status code:{response.StatusCode}");
}
else
Console.Write($"Error occurred. Status code: {response.StatusCode}");
}
}
}
}