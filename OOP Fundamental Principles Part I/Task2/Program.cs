using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace Task2
{
    class Program
    {
        static void Main(string[] args)
        {
            //Initialize an array of 10 students and sort them by grade in ascending order.
            List<Student> students = new List<Student>()
          { 
              new Student( "Student1","S1Lastname", 9 ),
              new Student( "Student2","S2Lastname", 7 ),
              new Student( "Student3","S3Lastname", 3 ),
              new Student( "Student4","S4Lastname", 4 ),
              new Student( "Student5","S5Lastname", 5 ),
              new Student( "Student6","S6Lastname", 8 ),
              new Student( "Student7","S7Lastname", 2 ),
              new Student( "Student8","S8Lastname", 1 ),
              new Student( "Student9","S9Lastname", 10 ),
              new Student( "Student10","S10Lastname", 6 )
          };
            
            foreach (var item in students)
            {
                Console.WriteLine(item.FirstName + " Grade = " + item.Grade);
            }
            
            students.Sort(Student.CompareGrades);
            
            Console.WriteLine("----Sorted----");
            foreach (var item in students)
            {
                Console.WriteLine(item.FirstName + " Grade = " + item.Grade);
            }

            //Initialize an array of 10 workers and sort them by money per hour in descending order.
            List<Worker> workers = new List<Worker>()
          { 
              new Worker( "Worker1","S1Lastname", 250, 20 ),
              new Worker( "Worker2","S2Lastname", 350, 20 ),
              new Worker( "Worker3","S3Lastname", 50, 20 ),
              new Worker( "Worker4","S4Lastname", 1500, 20 ),
              new Worker( "Worker5","S5Lastname", 800, 20 ),
              new Worker( "Worker6","S6Lastname", 210, 20 ),
              new Worker( "Worker7","S7Lastname", 30, 20 ),
              new Worker( "Worker8","S8Lastname", 145, 20 ),
              new Worker( "Worker9","S9Lastname", 731, 20 ),
              new Worker( "Worker10","S10Lastname", 235, 20 )
          };

            foreach (var item in workers)
            {
                Console.WriteLine(item.FirstName + " Money per Hour= " + item.MoneyPerHour());
            }

            workers.Sort(Worker.CompareMoneyPerHour);

            Console.WriteLine("----Sorted----");
            foreach (var item in workers)
            {
                Console.WriteLine(item.FirstName + " Money per Hour= " + item.MoneyPerHour());
            }
        }
    }
}
