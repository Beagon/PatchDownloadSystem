using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.IO;
using System.Net;
using Newtonsoft.Json;

namespace PatchDownloadClient
{
    class Program
    {
        static void Main(string[] args)
        {
            WebClient client = new WebClient();
            string downloadString = client.DownloadString("http://localhost/PatchDownloadServer/patches.php");
            var patches = JsonConvert.DeserializeObject<List<Patches>>(downloadString);
            foreach (Patches patch in patches)
            {
                WebClient webClient = new WebClient();
                //webClient.DownloadFileCompleted += new AsyncCompletedEventHandler(Completed);
                Directory.CreateDirectory("patches");
                Console.WriteLine("Downloading file: " + "patches/" + patch.file);
                webClient.DownloadFile(new Uri(patch.url),"patches/" + patch.file);
                //webClient.DownloadFileAsync(new Uri(patch.url), patch.file);
            }
            Console.WriteLine("All files downloaded. Press any key to exit.");
            Console.ReadKey();
        }

        public static void Completed(object sender, AsyncCompletedEventArgs e)
        {
            Console.WriteLine("Completed.");
        }
    }

    public class Patches
    {
        public int id { get; set; }
        public string url { get; set; }
        public string file { get; set; }
        public int priority { get; set; }
    }
}
